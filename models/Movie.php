<?php 
require_once 'includes/api.php';

class Movie {
    private $conn;

    public function __construct() {
        $this->conn = curl_init();
    }

    public function search($query) {
        
        $url = API_URL . '3/search/multi?query=' . urlencode($query) . '&include_adult=false&language=en-US&page=1';
        
        curl_setopt($this->conn, CURLOPT_URL, $url);
        curl_setopt($this->conn, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->conn, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . API_KEY,
            'Accept: application/json',
        ]);
        
        $response = curl_exec($this->conn);
        
        if (curl_errno($this->conn)) {
            echo 'Error:' . curl_error($this->conn);
        } else {
            return json_decode($response, true);
        }
        
        curl_close($this->conn);
    }

}