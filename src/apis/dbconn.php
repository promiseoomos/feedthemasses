<?php

		function dbconn(){

            //$dsn = "mysql:host=localhost;dbname=futavill_quicktest";
            //$username = "futavill_quicktester";
            //$password = "promzy31258";

            $dsn = "mysql:host=localhost;dbname=feedthemasses";
            $username = "feeders";
            $password = "feed@Masses";
    
            try {
                $conn = new PDO($dsn, $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Could not Connect to Database". $e->getMessage();
            }
    
            
    
            return $conn;
        }


?>