<?php

require_once '../config.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRep = $_POST['confirm-password'];

    
} else {
    header('location: ./index.php');
}
