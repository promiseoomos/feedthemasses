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
                    $newdetails = array(
                        "fname" => $row['first_name'],
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
                        "trackid" => $row['track_id'],
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

    public function getDownlines(){

    }

    public function promoteUser(){

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
}