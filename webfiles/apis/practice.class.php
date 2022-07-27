<?php
include_once "dbconn.php";

$conn = dbconn();

// $downlines = Array();~

// $downlines[] = Array(
//     "name" => "first_level",
//     "referrals" => Array()
// );

// foreach($downlines as $down){
//     echo $down["name"];
// }
// print_r($downlines[0]["name"]);

function generateVoucher(){
    $genkeys = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $numkeys = strlen($genkeys);
    $ref = '';
    for($i=0;$i< 10; $i++){
        $pos = rand(0, $numkeys);
        $ref .= substr($genkeys, $pos, 1);
    }

    
    return $ref;
}

// $fh = fopen("../apis/vouchers.txt", "w+");

// // $sql = "INSERT INTO `voucher`(`track_id`, `voucher_pin`, ) VALUES ()";

// for($i=0; $i<= 10000; $i++){
//     $voucher = generateVoucher();

//     // echo $voucher;
//     // echo "<br>";
//     $trackid = "{$i}00{$voucher}";
//     $sql = "INSERT INTO `voucher`(`track_id`, `voucher_pin`) VALUES ('$trackid', '$voucher')";
//     $query = $conn->prepare($sql);
//     $query->execute();

//     fwrite($fh, $i+1 . ". ");
//     fwrite($fh, $voucher);
//     fwrite($fh, "\n");
// }

// fclose($fh);

$uri =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriarray = explode("/", $uri);

echo $uri; echo "<br>";
print_r($uriarray);
echo $uriarray[1];