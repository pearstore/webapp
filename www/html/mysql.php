<?php
$_MYSQL_CONNECTION = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");

class DBCONN {
    private string $host    = 'pearshop_db';
    private string $user    = 'pearshop';
    private string $pass    = 'itsstuttgart';
    private string $db      = 'pearstore_database';
   
   
    function __construct() {
        $this->conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
    }

    function output(string $sql, array $params) {
        $conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
        $stmt = $conn->prepare($sql);
        $response = False;

        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        $execute = $stmt->execute();
        if( $execute === True ) {
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $response = $result->fetch_array(MYSQLI_ASSOC);
            }
        }
        $conn->close();
        return $response;
    }
    function input(string $sql, array $params){
        $conn = mysqli_connect($this->host,$this->user,$this->pass,$this->db);
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        $conn->close();
        return $stmt->execute();
    }
} 

?>