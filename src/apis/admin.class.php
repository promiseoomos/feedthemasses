<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
header("Access-Control-Allow-Headers: Origin,X-Requested-With,Content-Type, Accept, Cache-Control, Pragma, *");
// require_once "phpmailer/PHPMailerAutoload.php";
include_once "dbconn.php";
// include_once "functions.php";
spl_autoload_register(function($class){
    //echo $class;
    include strtolower($class).".class.php";
});

class Admin extends Functions {
    public function login($conn, $userObj){
        $clearance = $userObj->clearance;
        $password = $userObj->password;

        if (empty($clearance) || empty($password)) {
            $response = array(
                "loggedin" => false,
                "message" => "empty",
            );

            goto resolution;
        }

        try {
            $sql = "select * from admins where admin_clearance = '{$clearance}'";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();

            $hashpassword = '';

            foreach ($result as $row) {
                $hashpassword = $row['admin_password'];
    
                $newdetails = array(
                    "admin_name" => $row['admin_name'],
                    "clearance" => $row['admin_clearance'],
                    "track_id" => $row['admin_id'],
                );
            }

            if (password_verify($password, $hashpassword)) {
                
                $response = array(
                    "loggedin" => true,
                    "message" => "login successful",
                    "details" => $newdetails,
                );
                
            } else {
                $response = array(
                    "loggedin" => false,
                    "message" => "incorrect",
                );
            }

            goto resolution;

        } catch (PDOException $e) {
            $response = array(
                "message" => "error" . $e->getMessage(),
            );

            goto resolution;
        }



        resolution:
        echo json_encode($response);
    }

    public function stagename($userstage){

        switch($userstage){
            case 0 :
                $stage_name = "Feeders";
            break;
            case 1 :
                $stage_name = "Bronze";
            break;
            case 2 :
                $stage_name = "Silver";
            break;
            case 3 :
                $stage_name = "Gold";
            break;
            case 4 :
                $stage_name = "Diamond";
            break;
            case 5 :
                $stage_name = "Platinum";
            break;
            default :
                $stage_name = "Feeders";
            break;
        }

        return $stage_name;
    }

    public function getInfoStats($conn){
        
        $totalusers = 0;
        $totalrevenue = 0;
        $totalvouchers = 0;
        $totalvouchersused = 0;
        $totalcollectionsrequested = 0;
        $totalcollectionscollected = 0;
        $totaldispensedcrw = 0;
        $totaldispensedfrw = 0;

        try {
            $sqlusers = "select * from users";
            $queryusers = $conn->prepare($sqlusers);
            $queryusers->execute();
            $resultusers = $queryusers->fetchAll();
            $countusers = count($resultusers);

            $sqlvouchersused = "select * from voucher where status = 'Used'";
            $queryvouchersused = $conn->prepare($sqlvouchersused);
            $queryvouchersused->execute();
            $resultvouchersused = $queryvouchersused->fetchAll();
            $countvouchersused = count($resultvouchersused);

            $sqlvoucherscreated = "select * from voucher";
            $queryvoucherscreated = $conn->prepare($sqlvoucherscreated);
            $queryvoucherscreated->execute();
            $resultvoucherscreated = $queryvoucherscreated->fetchAll();
            $countvoucherscreated = count($resultvoucherscreated);

            $sqlcollectionsreq = "select * from collections";
            $querycollectionsreq = $conn->prepare($sqlcollectionsreq);
            $querycollectionsreq->execute();
            $resultcollectionsreq = $querycollectionsreq->fetchAll();
            $countcollectionsreq = count($resultcollectionsreq);

            $sqlcollectionsgiven = "select * from collections where status = 'Collected'";
            $querycollectionsgiven = $conn->prepare($sqlcollectionsgiven);
            $querycollectionsgiven->execute();
            $resultcollectionsgiven = $querycollectionsgiven->fetchAll();
            $countcollectionsgiven = count($resultcollectionsgiven);

            $totalrevenue = $countvouchersused * 1000;
            $totalusers = $countusers;
            $totalvouchers = $countvoucherscreated;
            $totalvouchersused = $countvouchersused;
            $totalcollectionscollected = $countcollectionsgiven;
            $totalcollectionsrequested = $countcollectionsreq;

            $infostats = Array(
                "total_revenue" => $totalrevenue,
                "total_users" => $totalusers,
                "total_vouchers" => $totalvouchers,
                "total_vouchers_used" => $totalvouchersused,
                "total_collections_collected" => $totalcollectionscollected,
                "total_collections_requested" => $totalcollectionsrequested
            );
             
            echo json_encode($infostats);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getUsers($conn){
        
        try {
            $sql = "select * from users";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $count = count($result);
            $tabledata = Array();

            if($count > 0){
                foreach($result as $row){
                
                    $tabledata[] = Array(
                        "first_name" => $row['first_name'],
                        "surname" => $row['surname'],
                        "phone" => $row['phone'],
                        "User ID" => $row['track_id'],
                        "referrer_id" => $row['referrer_id'],
                        "stage" => $row['stage'],
                        "status" => $row['status']
                    );
                }
            }

            $return = Array(
                "datacount" => $count,
                "tabledata" => $tabledata
            );

            echo json_encode($return);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function getVouchers($conn){

        $filename = "vouchers.csv";
        $upload_path = "files/$filename";
        $url = "apis/files/$filename";

        
        $filelink = $url;
        $fh = fopen("$upload_path", "wb+");

        $firsttitle = Array("", "", "FEED THE MASSES PLUS");
        $secondtitle = Array("","", "PAYMENT VOUCHERS");

        $columnsheader = Array("S/N","Voucher Pin","Voucher Status");
        
        fputcsv($fh, $firsttitle);
        fputcsv($fh, $secondtitle);
        fputcsv($fh, $columnsheader);


        try {
            $sql = "select * from voucher";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $count = count($result);
            $tabledata = Array();

            if($count > 0){
                $index = 1;
                foreach($result as $row){
                
                    $tabledata[] = Array(
                        "voucher_pin" => $row['voucher_pin'],
                        "voucher_user" => $row['voucher_user'],
                        "status" => $row['status'],
                        "used_date" => $row['used_date'],
                        "track_id" => $row['track_id'],
                    );

                    $csvrows = array($index,$row['voucher_pin'],$row['status']);
                    fputcsv($fh, $csvrows);

                    $index += 1;
                }
            }

            $return = Array(
                "datacount" => $count,
                "tabledata" => $tabledata,
                "url" => $url
            );

            echo json_encode($return);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getCollections($conn){
        try {
            $sql = "select * from collections order by date_requested desc";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $count = count($result);
            $tabledata = Array();

            if($count > 0){
                foreach($result as $row){
                    
                    $sqluser = "select * from users where track_id = {$row['user_id']}";
                    $queryuser = $conn->prepare($sqluser);
                    $queryuser->execute();
                    $resultuser = $queryuser->fetchAll();
                    $countuser = count($resultuser);

                    if($countuser > 0){
                        foreach($resultuser as $rowuser){
                            $userdetails = Array(
                                "first_name" => $rowuser['first_name'],
                                "surname" => $rowuser['surname'],
                                "username" => $rowuser['username'],
                                "phone" => $rowuser['phone'],
                                "User_id" => $rowuser['track_id'],
                                "referrer_id" => $rowuser['referrer_id'],
                                "stage" => $rowuser['stage'],
                                "status" => $rowuser['status'],
                                "address" => $rowuser['address'],
                                "next_of_kin" => $rowuser['next_of_kin'],
                                "next_of_kin_phone" => $rowuser['next_of_kin_phone'],
                                "bank_name" => $rowuser['bank_name'],
                                "account_name" => $rowuser['account_name'],
                                "account_number" => $rowuser['account_number']
                            );
                        }
                    }
                    $tabledata[] = Array(
                        "user_id" => $row['user_id'],
                        "user_details" => $userdetails,
                        "stage" => $row['stage'],
                        "stagename" => $this->stagename($row['stage']),
                        "option" => $row['option'],
                        "status" => $row['status'],
                        "date_approved" => $row['date_approved'],
                        "track_id" => $row['track_id'],
                    );
                }
            }

            

            $return = Array(
                "datacount" => $count,
                "tabledata" => $tabledata
            );

            echo json_encode($return);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function generateVouchers($conn, $vouchers_count){
        $voucher_pin = function(){
            $genkeys = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            $numkeys = strlen($genkeys);
            $ref = '';
            
            for($i=0;$i< 10; $i++){
                $pos = rand(0, $numkeys);
                $ref .= substr($genkeys, $pos, 1);
            }

            return $ref;
        };

        // $fh = fopen("../apis/vouchers.txt", "w+");

        // $sql = "INSERT INTO `voucher`(`track_id`, `voucher_pin`, ) VALUES ()";

        for($i=0; $i <= $vouchers_count; $i++){
            $voucher = $voucher_pin();

            // echo $voucher;
            // echo "<br>";
            $trackid = $this->checktrackid($conn, "voucher");
            $sql = "INSERT INTO `voucher`(`track_id`, `voucher_pin`) VALUES ('$trackid', '$voucher')";
            $query = $conn->prepare($sql);
            $query->execute();

            // fwrite($fh, $i+1 . ". ");
            // fwrite($fh, $voucher);
            // fwrite($fh, "\n");
        }
    }

    public function approveRequest($conn, $rid){
        $d = new DateTime();
        $curd = $d->format("d, F Y");
        
        try {
            $sql = "UPDATE `collections` SET `status`='Approved',`date_approved`='$curd' WHERE track_id = '$rid'";
            $query = $conn->prepare($sql);
            $query->execute();

            if($query){
                $return = Array(
                    "status" => true,
                    "msg" => "Approved"
                );
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        echo json_encode($return);
    }

    public function disapproveRequest($conn, $rid){
        $d = new DateTime();
        $curd = $d->format("d, F Y");
        
        try {
            $sql = "UPDATE `collections` SET `status`='Disapproved',`date_approved`='$curd' WHERE track_id = '$rid'";
            $query = $conn->prepare($sql);
            $query->execute();

            if($query){
                $return = Array(
                    "status" => true,
                    "msg" => "Disapproved"
                );
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        echo json_encode($return);
    }

    public function collectedRequest($conn, $rid){

    }

    public function getRewards(){

    }

    public function updateReward($rewardObj, $stage){
        echo "updateing Reward";
    }

}

$data = json_decode(file_get_contents("php://input"));
$conn = dbconn();
$session = new Admin();

switch($data->action){
    case "login" :
        $session->login($conn, $data->adminObj);
    break;
    case "get-info-stats" :
        $session->getInfoStats($conn);
    break;
    case "get-vouchers":
        $session->getVouchers($conn);
    break;
    case "get-collections" :
        $session->getCollections($conn);
    break;
    case "get-users" :
        $session->getUsers($conn);
    break;
    case "generate-vouchers" :
        $session->generateVouchers($conn, $data->vouchers_count);
    break;
    case "approve-request" :
        $session->approveRequest($conn, $data->rid);
    break;
    case "disapprove-request" :
        $session->disapproveRequest($conn, $data->rid);
    break;
    case "update-reward" :
        $session->updateReward($conn, $data->rewardObj, $data->stage);
    break;
    
}