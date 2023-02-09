<?php
session_start();
unset($_SESSION['margaux_admin_id']);
header("Location: login.php");