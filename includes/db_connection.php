<?php
function get_connection() {
    $servername = "192.168.1.7";
    $username = "root";
    $password = "admin";
    $dbname = "movies_db";

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
    }catch(Exception $e){
        die("Connection failed: " . $e->getMessage());
    }
    
    return $conn;
}
