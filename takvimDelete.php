<?php
require "dbbaglanti.php";

if(isset($_POST)){
    $sorgu = $dbbaglanti->prepare("DELETE FROM olayveri WHERE eventId=?");
    $sorgu -> execute(array(
        $_POST["id1"]
    ));
}
