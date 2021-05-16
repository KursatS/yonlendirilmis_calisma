<?php

session_start();
ob_start();

try {
    $dbbaglanti = new PDO("mysql:host=localhost;dbname=yonlendirilmis_calisma;charset=utf8",'root',"");

} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

?>
