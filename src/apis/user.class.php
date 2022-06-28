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
    public function signUp(){

    }

    public function getDownlines(){

    }

    public function promoteUser(){
        
    }
}