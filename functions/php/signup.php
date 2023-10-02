<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordRep = $_POST['confirm-password'];

    require_once '../../db_connect.php';
    require_once '../../functions/php/functions.php';

    if (emptyInputSignup($email, $password, $passwordRep) !== false) {
        header('location: ../../registration/index.php?error=emptyinput');
        exit();
    }

    if (invalidEmail($email) !== false) {
        header('location: ../../registration/index.php?error=invalidemail');
        exit();
    }

    if (passwordMatch($password, $passwordRep) !== false) {
        header('location: ../../registration/index.php?error=passwordsdontmatch');
        exit();
    }

    if (userExists($link, $email) !== false) {
        header('location: ../../registration/index.php?error=emailtaken');
        exit();
    }

    createUser($link, $email, $password);
} else {
    header('location: ../../registration/index.php');
    exit();
}
