
<?php
require "dbbaglanti.php";

session_start();
session_destroy();
header('Location: giris.php');
?>