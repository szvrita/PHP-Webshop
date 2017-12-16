<?php

session_start();
include 'reso/frames/header.php';
include 'reso/frames/connection.php';

unset($_SESSION['logged_in']);
unset($_SESSION['products']);
session_destroy();
session_unset();

setcookie('PHPSESSID', '', time() - 3000, '/');

header('location: login.php');

 ?>
