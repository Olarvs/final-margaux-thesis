<?php
session_start();

unset($_SESSION['margaux_user_id']);
unset($_SESSION['margaux_name']);

header('location: index.php');
?>