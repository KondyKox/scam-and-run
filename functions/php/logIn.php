<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once '../../db_connect.php';
    require_once '../../functions/php/functions.php';

    if (emptyInputLogin($email, $password) !== false) {
        header('location: ../../login/index.php?error=emptyinput');
        exit();
    }

    loginUser($link, $email, $password);
} else {
    header('location: ../../login/index.php');
    exit();
}
