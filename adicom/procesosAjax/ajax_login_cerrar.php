<?php
session_start();
$_SESSION['acceso'] == false;
session_destroy();

header ("Location: ../index.php ");
?>
