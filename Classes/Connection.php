<?php
require_once '../_conf.php';
class MySqlConnectionManager {
    var $hostName, $userName, $passWord, $conHandle, $dataBase, $hostPort;

    function MySqlConnectionManager() {
        $this->hostName = HOST;
        $this->hostPort = PORT;
        $this->userName = USER;
        $this->passWord = PASSWORD;
        $this->dataBase = DATABASE;
    }

    function doConnection() {
        if (!($this->conHandle = mysqli_connect($this->hostName, $this->userName, $this->passWord, $this->dataBase,$this->hostPort))) {
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error() . "__" . mysqli_connect_errno();
            }
            die("Connection Failed");
        }
    }
    function getConnectionHandle() {
        return $this->conHandle;
    }

}
$conCls = new MySqlConnectionManager();
$conCls->doConnection();
$con = $conCls->getConnectionHandle();

unset($conCls);
?>