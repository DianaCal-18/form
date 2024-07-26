<?php

class Conexion{

  private $host='sql110.infinityfree.com';
  private $dbname='if0_36960691_libreriadc';
  private $username='if0_36960691';
  private $password='Calderon18Diana';

public function ConexionBD(){

    $dns = "mysql:host=$this->host;dbname=$this->dbname";
    $obPDO = new PDO($dns, $this->username,$this->password);

    return $obPDO;

}

}

?>