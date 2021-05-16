<?php
require "dbbaglanti.php";

if(isset($_POST["title"])){
    $sorgu = $dbbaglanti->prepare("INSERT INTO olayveri SET title =?, start_event=?, end_event=?");
    $sorgu -> execute(array(
        $_POST["title"],$_POST["start"],$_POST["end"]
    ));
}
