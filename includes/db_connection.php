<?php
function get_connection() {
    $servername = "172.17.0.1";
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
