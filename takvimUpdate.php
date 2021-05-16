<?php
require "dbbaglanti.php";

if (isset($_POST)) {
    $sorgu = $dbbaglanti->prepare("UPDATE olayveri SET start_event=?, end_event=? WHERE eventId=?");
    $sorgu->execute(array(
        $_POST["start1"], $_POST["end1"], $_POST["id"]
    ));
}
