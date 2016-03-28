<?php
session_start();
session_destroy();

header("Location: ../Weak/Login.php") ;
?>
