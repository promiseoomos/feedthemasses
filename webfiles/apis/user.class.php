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

class User extends Functions {
    public function signUp($conn, $userObj){

        $first_name = $userObj->first_name;
        $surname = $userObj->surname;
        $email = $userObj->email;
        $username = $userObj->username;
        $phone = $userObj->phone;
        $password = $userObj->password;
        $bank_name = $userObj->bank_name;
        $account_name = $userObj->account_name;
        $account_number = $userObj->account_number;
        $next_of_kin = $userObj->next_of_kin;
        $next_of_kin_phone = $userObj->next_of_kin_phone;
        $address = $userObj->address;
        $referrer_id = $userObj->referrer_id;
        $voucher_pin = $userObj->voucher_pin;
        $track_id = $this->checktrackid($conn, "users");

        try {
            pumpplace:
            $sqlref = "select * from users where referrer_id = '$referrer_id' order by RAND()";
            $queryref = $conn->prepare($sqlref);
            $queryref->execute();
            $resultref = $queryref->fetchAll();

            $countref = count($resultref);

            if($countref >= 3){
                foreach($resultref as $rowref){
                    $checked[] = $rowref['track_id'];
                    $referrer_id = $rowref['track_id'];

                    if(!in_array($referrer_id, $checked)){
                        goto pumpplace;
                    }
                    
                }
            }

        } catch (PDOException $e) {
            //throw $th;
        }
        

        $insert = true;

        $d = new DateTime();
        $curd = $d->format("d, F Y");
        
        // Hash the Password before inserting into the database.
        // From this point only the Hashing script and the password owner knows the real password
        $hashpassword = password_hash($password, PASSWORD_BCRYPT);
        // Email Checker. Checks if the email is existing
        $emch = $this->checkavailable($conn, "email", $email);
        // Username Checker. Checks if the username is existing
        $unch = $this->checkavailable($conn, "username", $username);

        try {
            $sqlvoucher = "select * from voucher where voucher_pin = '$voucher_pin'";
            $queryvoucher = $conn->prepare($sqlvoucher);
            $queryvoucher->execute();
            $resultvoucher = $queryvoucher->fetchAll();
            $vouchercount = count($resultvoucher);

            if($vouchercount > 0){
                
                foreach($resultvoucher as $rowvoucher){
                    // Check if the Voucher has been used already and prevent the user from registering if the voucher has been used
                    if($rowvoucher['status'] == 'Used'){
                        $return = Array(
                            "msg" => "Voucher Pin has already been used",
                            "signedup" => false,
                            "reason" => "used_voucher"
                        );
                        $insert = false;

                        goto resolution;
                    }
                }
            }else{
                // Check if the Voucher pin does not exist and prevent the user from registering if such pin is not in the database
                $return = Array(
                    "msg" => "Voucher Pin does not Exist",
                    "signedup" => false,
                    "reason" => "incorrect_voucher"
                );

                $insert = false;

                goto resolution;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        if (!$emch) {
            // If email exists, alert the user to use a different email
            $return = Array(
                "msg" => "Email Already Exists. Use a different email address.",
                "signedup" => false,
                "reason" => "existing_email"
            );
            $insert = false;

            goto resolution;
        }

        if (!$unch) {
            $return = Array(
                "msg" => "Username already exists. Use a different Username.",
                "signedup" => false,
                "reason" => "existing_username"
            );
            $insert = false;

            goto resolution;
        }

        if($insert){
            $sql =<<<SQLite
                INSERT INTO `users`(`track_id`, `referrer_id`, `first_name`, `surname`, `username`, `password`, `phone`, `email`, `address`, `next_of_kin`, `next_of_kin_phone`, `bank_name`, `account_name`, `account_number`, `voucher_pin`, `joined_date`) 
                VALUES ("$track_id", "$referrer_id", "$first_name", "$surname", "$username", "$hashpassword", "$phone", "$email", "$address", "$next_of_kin", "$next_of_kin_phone", "$bank_name", "$account_name", "$account_number","$voucher_pin", "$curd")
SQLite;

            $query = $conn->prepare($sql);
            $query->execute();

            if ($query) {
                $return = Array(
                    "signedup" => true,
                    "msg" => "Thanks for Signing up. You can now Login."
                );

                $voucherupdatesql = "UPDATE `voucher` SET `voucher_user`='$track_id',`status`='Used',`used_date`='$curd' WHERE voucher_pin = '$voucher_pin'";
                $voucherupdatequery = $conn->prepare($voucherupdatesql);
                $voucherupdatequery->execute();

                goto resolution;
            }
        }

        resolution:
        echo json_encode($return);
    }

    public function login($conn, $userObj){
        $username = $userObj->username;
        $password = $userObj->password;

        if (empty($username) || empty($password)) {
            $response = array(
                "loggedin" => false,
                "message" => "empty",
            );

            goto resolution;
        }

        try {
            $sql = "select * from users where username = '{$username}'";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();

            $hashpassword = '';

            foreach ($result as $row) {
                $hashpassword = $row['password'];
                // $confirmed = $row['email_confirmed'];
                $referrerid = $row['referrer_id'];
                $track_id = $row['track_id'];

                    $sqlsponsor = "select * from users where track_id = '$referrerid'";
                    $querysponsor = $conn->prepare($sqlsponsor);
                    $querysponsor->execute();
                    $resultsponsor = $querysponsor->fetchAll();
                    $countsponsor = count($resultsponsor);

                    if($countsponsor > 0){
                        foreach($resultsponsor as $rowsponsor){
                            $sponsor_username = $rowsponsor['username'];
                        }
                    }else{
                        $sponsor_username = "";
                    }

                    $sqlreferrals = "select track_id from users where referrer_id = '$track_id'";
                    $queryreferrals = $conn->prepare($sqlreferrals);
                    $queryreferrals->execute();
                    $resultreferrals = $queryreferrals->fetchAll();
                    $countreferrals = count($resultreferrals);

                    $newdetails = array(
                        "first_name" => $row['first_name'],
                        "surname" => $row['surname'],
                        "fullname" => $row['first_name'] . " " . $row['surname'],
                        "email" => $row['email'],
                        "username" => $row['username'],
                        "phone" => $row['phone'],
                        "address" => $row['address'],
                        "bank_name" => $row['bank_name'],
                        "account_name" => $row['account_name'],
                        "account_number" => $row['account_number'],
                        "next_of_kin" => $row['next_of_kin'],
                        "next_of_kin_phone" => $row['next_of_kin_phone'],
                        "referrer_id" => $row['referrer_id'],
                        "referrer_username" => $sponsor_username,
                        "referrals_count" => $countreferrals,
                        "stage" => $row['stage'],
                        "track_id" => $row['track_id'],
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

    public function getDownlines($conn, $track_id){
        
        // $userid = $userObj->userid;

        try{

            $sql = "Select * from users where referrer_id = '$track_id' limit 3";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $count = count($result);

            $leveluid = Array(); $leveluid2 = Array(); $leveluid3 = Array(); $leveluid4 = Array(); $leveluid5 = Array();
            
            $downlines = Array();
            $deepLevel = 0;

            if($count > 0){
                $deepLevel += 1;
                $downlines[] = Array(
                    "name" => "first_level",
                    "referrals" => Array()
                );
                foreach($result as $row){

                    $username = $row['username'];
                    $track_id = $row['track_id'];
                    $upline = $row['referrer_id'];
                    $stage = $row['stage'];

                    $leveluid[] = $track_id;

                    $downlines[0]["referrals"][] = Array(
                        "username" => $username,
                        "userid" => $track_id,
                        "uplineid" => $upline,
                        "stage" => $stage
                    );

                }

                $countlevel2 = count($leveluid);
                
                if($countlevel2 > 0){
                    $deepLevel += 1;
                    $downlines[] = Array(
                        "name" => "second_level",
                        "referrals" => Array()
                    );

                    foreach($leveluid as $userid){

                        try {
                            $sqllevel2 = "Select * from users where referrer_id = '$userid' limit 3";
                            $querylevel2 = $conn->prepare($sqllevel2);
                            $querylevel2->execute();
                            $resultlevel2 = $querylevel2->fetchAll();
                            $countlevel2 = count($resultlevel2);

                            if($countlevel2 > 0){
                                foreach($resultlevel2 as $rowlevel2){
                                    $username = $rowlevel2['username'];
                                    $track_id = $rowlevel2['track_id'];
                                    $upline = $rowlevel2['referrer_id'];
                                    $stage = $rowlevel2['stage'];

                                    $leveluid2[] = $track_id;
                
                                    $downlines[1]["referrals"][] = Array(
                                        "username" => $username,
                                        "userid" => $track_id,
                                        "uplineid" => $upline,
                                        "stage" => $stage
                                    );
                                }
                            }
                            

                        } catch (PDOException $e) {
                            //throw $th;
                        }
                    }
                }

                $countlevel3 = count($leveluid2);

                if($countlevel3 > 0){
                    $deepLevel += 1;
                    $downlines[] = Array(
                        "name" => "third_level",
                        "referrals" => Array()
                    );

                    foreach($leveluid2 as $userid){
                        
                        try {
                            $sqllevel3 = "Select * from users where referrer_id = '$userid' limit 3";
                            $querylevel3 = $conn->prepare($sqllevel3);
                            $querylevel3->execute();
                            $resultlevel3 = $querylevel3->fetchAll();
                            $countlevel3 = count($resultlevel3);

                            if($countlevel3 > 0){
                                foreach($resultlevel3 as $rowlevel3){
                                    $username = $rowlevel3['username'];
                                    $track_id = $rowlevel3['track_id'];
                                    $upline = $rowlevel3['referrer_id'];
                                    $stage = $rowlevel3['stage'];
                                    $leveluid3[] = $track_id;
                
                                    $downlines[2]["referrals"][] = Array(
                                        "username" => $username,
                                        "userid" => $track_id,
                                        "uplineid" => $upline,
                                        "stage" => $stage
                                    );
                                }
                            }
                            

                        } catch (PDOException $e) {
                            //throw $th;
                        }
                    }

                } 

                $countlevel4 = count($leveluid3);

                if($countlevel4 > 0){
                    $deepLevel += 1;
                    $downlines[] = Array(
                        "name" => "fourth_level",
                        "referrals" => Array()
                    );

                    foreach($leveluid3 as $userid){
                        
                        try {
                            $sqllevel4 = "Select * from users where referrer_id = '$userid' limit 3";
                            $querylevel4 = $conn->prepare($sqllevel4);
                            $querylevel4->execute();
                            $resultlevel4 = $querylevel4->fetchAll();
                            $countlevel4 = count($resultlevel4);

                            if($countlevel4 > 0){
                                foreach($resultlevel4 as $rowlevel4){
                                    $username = $rowlevel4['username'];
                                    $track_id = $rowlevel4['track_id'];
                                    $upline = $rowlevel4['referrer_id'];
                                    $stage = $rowlevel4['stage'];
                                    $leveluid4[] = $track_id;
                
                                    $downlines[3]["referrals"][] = Array(
                                        "username" => $username,
                                        "userid" => $track_id,
                                        "uplineid" => $upline,
                                        "stage" => $stage
                                    );
                                }
                            }
                            

                        } catch (PDOException $e) {
                            //throw $th;
                        }
                    }
                }

                $countlevel5 = count($leveluid4);

                if($countlevel5 > 0){
                    $deepLevel += 1;
                    $downlines[] = Array(
                        "name" => "fifth_level",
                        "referrals" => Array()
                    );

                    foreach($leveluid4 as $userid){
                        
                        try {
                            $sqllevel5 = "Select * from users where referrer_id = '$userid' limit 3";
                            $querylevel5 = $conn->prepare($sqllevel5);
                            $querylevel5->execute();
                            $resultlevel5 = $querylevel5->fetchAll();
                            $countlevel5 = count($resultlevel5);

                            if($countlevel5 > 0){
                                foreach($resultlevel5 as $rowlevel5){
                                    $username = $rowlevel5['username'];
                                    $track_id = $rowlevel5['track_id'];
                                    $upline = $rowlevel5['referrer_id'];
                                    $stage = $rowlevel5['stage'];
                                    $leveluid5[] = $track_id;
                
                                    $downlines[4]["referrals"][] = Array(
                                        "username" => $username,
                                        "userid" => $track_id,
                                        "uplineid" => $upline,
                                        "stage" => $stage
                                    );
                                }
                            }
                            

                        } catch (PDOException $e) {
                            //throw $th;
                        }
                    }

                } 

                $return = Array(
                    "hasReferrals" => true,
                    "deepLevel" => $deepLevel,
                    "data" => $downlines,
                );
            }else{
                $return = Array(
                    "hasReferrals" => false
                );

                goto resolution;
            }
            
        } catch (PDOException $e){
            echo $e->getMessage();
        }

        resolution :
        echo json_encode($return);

    }

    public function promoteUser(){

    }

    public function updateUser($conn, $userObj){

    }

    public function requestCollection(){

    }
}

$data = json_decode(file_get_contents("php://input"));
$conn = dbconn();
$session = new User();

switch($data->action){
    case "login" :
        $session->login($conn, $data->userObj);
    break;
    case "signup" : 
        $session->signUp($conn, $data->userObj);;
    break;
    case "get-downlines" : 
        $session->getDownlines($conn, $data->track_id);
    break;
    case "update-user" :
        $session->updateUser($conn, $data->userObj);
    break;
}