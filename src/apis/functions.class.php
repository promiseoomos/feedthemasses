<?php
spl_autoload_register(function($class){
    //echo $class;
    include strtolower($class).".class.php";
});

class Functions{

    public function generatetrack(){

        $random1 = rand(100, 1000);
        $random2 = rand(1000, 10000000000);
        $track_id = "100" . $random1 . $random2;

        return $track_id;

    }
    public function sanitize2($var){

        $var = stripslashes($var);

        $var = strip_tags($var);

        trim($var);

        $var = htmlentities($var);

        return $var;

    }

    public function checktrackid($conn, $table, $checktype = "noloop", $tracksarray = []){
        set_time_limit(0);
        ignore_user_abort(true);

        // print_r($tracksarray);
        // echo $checktype;

        $track_id = "";
        try {
            $chktrack = $this->generatetrack();

            if($checktype == "noloop"){
                switch ($table) {
                    case "$table" : 
                        $sql = "select * from $table";
                        $sqlc = "select count(*) from $table";
                    break;
                }
    
                $query = $conn->prepare($sql);
                $query->execute();
    
                $num = $conn->query($sqlc)->fetchColumn();
    
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
                if ($num > 0) {
                    checker:
                    foreach ($result as $checker) {
                        if ($checker['track_id'] != $chktrack) {
                            $track_id = $chktrack;
                        } else {
                            $track_id = $this->generatetrack();
                            goto checker;
                        }
                    }
                } else {
                    $track_id = $chktrack;
                }
            }else if($checktype == 'loop'){
                checker2:
                if(!in_array($chktrack, $tracksarray)){
                    $track_id = $chktrack;
                }else{
                    $track_id = $this->generatetrack();
                    goto checker2;
                }
            }
            

            return $track_id;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function checkavailable($conn, $column, $item){

        if ($column == "email") {

            $sql = "select * from users where email = '$item'";
            $sqlc = "select count(*) from users where email = '$item'";
        } else if ($column == "username") {

            $sql = "select * from users where username = '$item'";
            $sqlc = "select count(*) from users where username = '$item'";
        }

        $query = $conn->prepare($sql);
        $query->execute();

        $num = $conn->query($sqlc)->fetchColumn();

        //$result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($num > 0) {

            if ($column == 'email') {
                return false;
            } else if ($column == 'username') {
                return false;
            }

        } else {
            return true;
        }

    }

    public function generatetrx(){
            
        $genkeys = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $numkeys = strlen($genkeys);
        $ref = '';
        for($i=0;$i< 10; $i++){
            $pos = rand(0, $numkeys);
            $ref .= substr($genkeys, $pos, 1);
        }

        return $ref;
    }

    public function checktrxcode($conn, $table, $column = 'trx_code'){
        $trx_code = "";

        try {
            $trx = $this->generatetrx();
               
            $sql = "select * from $table where $column = '$trx'";
            $sqlc = "select count(*) from $table where $column = '$trx'";
                        
            $query = $conn->prepare($sql);
            $query->execute();

            $num = $conn->query($sqlc)->fetchColumn();

            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if($num > 0){
                checker:
                foreach( $result as $checker){
                    if($checker['trx_code'] != $trx ){
                        $trx_code = $trx;
                    }else{
                        $trx_code = $this->generatetrx();
                        goto checker;
                    }
                }
            }else{
                $trx_code = $trx;
            }
            
            // $return = Array(
            //     "voucher" => $trx_code
            // );
            
            // echo json_encode($return);
            return $trx_code;

        } catch (PDOException $e) {
            echo $e->getMessage();
        } 
    }

    public function calcReadtime($body){

        $WPM = 256;
        $bodywithoutimage = "c";
        $wordcount = str_word_count($body);
        $imagecount = substr_count("<img", $body);

        $wordonlycount = $wordcount;
        return $wordcount;
    }

    public function createBloglink($title){
        return "ty-dfk";
    }

    public function checkOrgexpired($conn, $orgname){
        try{        
            $sql = "select * from premium where organization_name = '$orgname' && premium_expired = 'No'";
            $sqlc = "select count(*) from premium where organization_name = '$orgname' && premium_expired = 'No'";
        

            $query = $conn->prepare($sql);
            $queryc = $conn->prepare($sqlc);

            $query->execute();
            $queryc->execute();

            $result = $query->fetchAll();
            $resultc = $queryc->fetchColumn();
            
            if($resultc > 0 ){
                foreach($result as $row){
                    $premium_type = $row['premium_type'];
                    $date_payed = $row["date_payed"];
                    $premium_duration = $row['premium_duration'];
                    $premiumid = $row['track_id'];
                    $expires = $row['expiry_date'];

                    // $usertrack = $row['email'];

                    $payeddate = new DateTime("$date_payed");
                    $todaysdate = new DateTime();

                    $interval = $payeddate->diff($todaysdate);

                    if($premium_type == 'Monthly'){
                        $formatter = 'm';
                    }else if($premium_type == 'Annually'){
                        $formatter = 'y';
                    }else{
                        $formatter = 'd';
                    }
                    $datesdiff =  $interval->format("%$formatter");
                    // print_r($interval);
                    // echo "You have ". (7 - $datesdiff) ." days remaining";
                    if($premium_type != 'Credit'){
                        $plantype = "Subscription";

                        if($datesdiff >= $premium_duration){

                            $active = "Inactive";
    
                            $sqle = "UPDATE `premium` SET `premium_expired`= 'Yes' WHERE track_id = '$premiumid'";
                            $querye = $conn->prepare($sqle);
                            $querye->execute();    
    
                            $sqluporg = "UPDATE `organizations` SET `entries_available` = 0, `space_users` = '[]' where organization_name = '$orgname'";
                            $queryuporg = $conn->prepare($sqluporg);
                            $queryuporg->execute();
                        }else{
                            $active = "Active";
                        }
                    }else{
                        $active = "Active";
                        $plantype = "PAYG";
                    }

                    $sqlgetorg = "select * from organizations where organization_name = '$orgname'";
                    $querygetorg = $conn->prepare($sqlgetorg);
                    $querygetorg->execute();

                    $resultgetorg = $querygetorg->fetchAll();

                    foreach($resultgetorg as $roworg){
                        $credits_available = $roworg['credits_available'];
                        $entries_available = $roworg['entries_available'];
                    }

                    $returnObj = Array(
                        "active" => $active,
                        "current_plan" => $premium_type,
                        "current_plantype" => $plantype,
                        "duration" => $premium_duration,
                        "expires" => $expires,
                        "credits_available" => $credits_available,
                        "entries_available" => $entries_available
                    );
                }
            }else{
                $active = "Inactive";

                $returnObj = Array(
                    "active" => $active,
                );
            }
        

        } catch (PDOException $e){
            echo $e->getMessage();
        }

        return json_encode($returnObj);
    }

    public function checkTestwall($conn, $testspaceid, $wall, $startdate, $enddate){

        if($wall == 'Yes'){
            $date1 = new DateTime("$startdate");
            $date2 = new DateTime("$enddate");
            $datenow = new DateTime();

            $prelock = $date1->diff($datenow);
            $postlock = $datenow->diff($date2);
            $prenegative = $prelock->invert;
            $postnegative = $postlock->invert;
            // echo $prenegative;
            // print_r($prelock);
            // echo $prelock->format("%R%d");
            // $prediff = $prelock->format("%R%d");
            // $postdiff = $postlock->format("%R%d");
            // echo "<br><br>";
            // print_r($postlock);
            // echo $postlock->format("%R%d");

            $postdiff = $postlock->format("%R%d");

            if($prenegative == 1 && $postnegative == 1){
                $status = "Closed";
                $reason = "The Test has not Started";
            }else if($prenegative == 1 && $postnegative == 0){
                $status = "Closed";
                $reason = "The Test is yet to begin";
            }else if($postnegative == 0 && $prenegative == 0 && $postdiff == 0){
                $status = "Opened";
                $reason = "The Test has Started and is Ending today.";
            }else if($postnegative == 0 && $prenegative == 0 && $postdiff > 0){
                $status = "Opened";
                $reason = "The Test has Started and is Ending in $postdiff days time.";
            }else if($postnegative == 1 && $prenegative == 0 && $postdiff == 0){
                $status = "Opened";
                $reason = "The Test has Started and is Ending today.";
            }else{
                $status = "Closed";
                $reason = "The Test has ended";
            }
            

            $sqluptestspace = "UPDATE `test_spaces` SET test_status = '$status'";
            $queryuptestspace = $conn->prepare($sqluptestspace);
            $queryuptestspace->execute();

            $return = Array(
                "status" => $status,
                "reason" => $reason
            );
        }else{
            $sqluptestspace = "UPDATE `test_spaces` SET test_status = 'Opened'";
            $queryuptestspace = $conn->prepare($sqluptestspace);
            $queryuptestspace->execute();

            $return = Array(
                "status" => "Opened",
                "reason" => ""
            );
        }

        return $return;
    }

    public function checkTakefrequency($email, $takerstaken, $takefreqeuency){
        // print_r($takerstaken);

        $anytaken = count($takerstaken);
        // echo $anytaken;

        if($takefreqeuency > 0){
            if($anytaken > 0){
                foreach($takerstaken as $takers){
                    // $count = count($takers);
                    // echo $count;
                    $type = gettype($takers);
                    $kin = key($takerstaken);

                    if($type == 'object'){
                        if($takers->email == $email){
                            $userobj = $takerstaken[$kin];
                            // print_r($userobj);
                            if($userobj->frequency >= $takefreqeuency){
                                $returnObj = Array(
                                    "take_lock" => "Locked",
                                    "lock_reason" => "You have reached the Maximum number of times this Test can be taken by a User"
                                );
                            }else{
                                $returnObj = Array(
                                    "take_lock" => "Unlocked",
                                    "lock_reason" => "You have not exceeded the Take Frequency Limit"
                                );
                            }
                            // $correct_questions[$kin]["value"] = $correct_questions_subject;
                            // reset($correct_questions);
                            break;
                        }else{
                            $returnObj = Array(
                                "take_lock" => "Unlocked",
                                "lock_reason" => "You have not taken any Test Yet"
                            );
                        }
                    }else{
                        $returnObj = Array(
                            "take_lock" => "Unlocked",
                            "lock_reason" => "You have not taken any Test Yet"
                        );
                    }
                                        
                    // next($correct_questions);
                    
                }
            }else{
                $returnObj = Array(
                    "take_lock" => "Unlocked",
                    "lock_reason" => "You have not taken any Test Yet"
                );
            }
        }else{
            $returnObj = Array(
                "take_lock" => "Unlocked",
                "lock_reason" => "You can take this Test for Unlimited Number of Times"
            );
        }
        
        

        return $returnObj;
    }

    public function getUserfrequency($useremail, $takerstaken){
        $anytaken = count($takerstaken);

        if($anytaken > 0 ){
            foreach($takerstaken as $takers){
                // print_r($takers);
                
                $type = gettype($takers);
                // echo $type;
                $kin = key($takerstaken);
                if($type == 'object'){
                    // echo $takers->email;
                    if($takers->email == $useremail){
                        $existingkey = $kin;
                        return $takers->frequency;
                    }
                }
                next($takerstaken);
            }
        }else{
            return 0;
        }
    }

    public function updateSpace($conn, $testspace_id, $orgname, $useremail){
        try {
            $sqltestspace = "select takers_taken from test_spaces where track_id = '$testspace_id'";
            $querytestspace = $conn->prepare($sqltestspace);
            $querytestspace->execute();
            $resulttestspace = $querytestspace->fetchAll();

            $existingkey = -1;
            if(count($resulttestspace) > 0){
                foreach($resulttestspace as $rowtestspace){
                    $takerstaken = json_decode($rowtestspace['takers_taken']);
                    // print_r($takerstaken);
                    $anytaken = count($takerstaken);

                    if($anytaken > 0 ){
                        foreach($takerstaken as $takers){
                            // print_r($takers);
                            
                            $type = gettype($takers);
                            // echo $type;
                            $kin = key($takerstaken);
                            if($type == 'object'){
                                // echo $takers->email;
                                if($takers->email == $useremail){
                                    $existingkey = $kin;
                                }
                            }
                            next($takerstaken);
                        }
                    }
                    // echo $existingkey;

                    if($existingkey >= 0){
                        $userobj = $takerstaken[$existingkey];
                        $previousfreq = $userobj->frequency;
                        $newfreq = $previousfreq + 1;
                        
                        $newobj = Array(Array(
                            "email" => $useremail,
                            "frequency" => $newfreq
                        ));
                        
                        array_splice($takerstaken, $existingkey, 1, $newobj);
                    }else if($existingkey == -1){
                        $takerstaken[] = Array(
                            "email" => $useremail,
                            "frequency" => 1
                        );
                    }
                    
                    
                }
                // print_r($newtakersobj);
                $readydata = json_encode($takerstaken);
    
                $sqluptestspace = "UPDATE test_spaces SET `takers_taken` = '$readydata' where track_id = '$testspace_id'";
                $queryuptestspace = $conn->prepare($sqluptestspace);
                $queryuptestspace->execute();
            }
           

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        try {
            $sqlorgspace = "select solid_users from organizations where organization_name = '$orgname'";
            $queryorgspace = $conn->prepare($sqlorgspace);
            $queryorgspace->execute();
            $resultorgspace = $queryorgspace->fetchAll();

            foreach($resultorgspace as $roworgspace){
                $solidusers = json_decode($roworgspace['solid_users']);

                if(!in_array($useremail, $solidusers)){
                    $solidusers[] = $useremail;
                }
            }
            $newsolid = json_encode($solidusers);
            $sqluporgspace = "UPDATE organizations SET `solid_users` = '$newsolid' where organization_name = '$orgname'";
            $queryuporgspace = $conn->prepare($sqluporgspace);
            $queryuporgspace->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function cleanNumber($number){
        $patt = "/\s/";
        $patt2 = "/\D/";
        $patt3 = "/^0/";

        $cleannumber1 = preg_replace($patt, "", $number);
        $cleannumber2 = preg_replace($patt2, "", $cleannumber1);
        $finalclean = preg_replace($patt3, "234", $cleannumber2);
        
        return $finalclean;
    }

    public function sendWhatsapp($messageObj, $number){

        // print_r($messageObj);
        // echo $number;
        $apitoken = "J0fofCKxcrGh2MxWvFLB";
        $sender = "2348161431425";
        $receiver = $number;
        $msg = str_replace("&nbsp;","\n\n", strip_tags(htmlspecialchars_decode($messageObj['body'])));
        $image = $messageObj['image'];
        $endpointurl = 'https://trenalyze.com/send';

        $queryfields = [
            'receiver'  => "$receiver",
            'msgtext'   => "$msg",
            'sender'    => "$sender",
            'token'     => "$apitoken",
            'mediaurl'  => "",
        ];
     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($queryfields));
        curl_setopt($ch, CURLOPT_URL, $endpointurl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
     
        echo $response;
    }

}
