<?php

// Check if signup inputs are empty
function emptyInputSignup($email, $password, $passwordRep)
{
    $result = false;

    if (empty($email) || empty($password) || empty($passwordRep))
        $result = true;

    return $result;
}

// Check if email is correct
function invalidEmail($email)
{
    $result = false;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $result = true;

    return $result;
}

// Check if passwords match
function passwordMatch($password, $passwordRep)
{
    $result = false;

    if ($password !== $passwordRep)
        $result = true;

    return $result;
}

// Check if email is already taken
function userExists($link, $email)
{
    $sql = "SELECT * FROM users WHERE email = ?;";

    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../../registration/index.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData))
        return $row;
    else
        return false;

    mysqli_stmt_close($stmt);
}

// Create user
function createUser($link, $email, $password)
{
    $sql = "INSERT INTO users (email, password) VALUES (?, ?);";

    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../../registration/index.php?error=stmtfailed');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('location: ../../../login/index.php?error=none');
    exit();
}

// Check if login inputs are empty
function emptyInputLogin($email, $password)
{
    $result = false;

    if (empty($email) || empty($password))
        $result = true;

    return $result;
}

// Login user
function loginUser($link, $email, $password)
{
    $userExists = userExists($link, $email);

    if (!$userExists) {
        header("location: ../../../login/index.php?error=wrongemail");
        exit();
    }

    $passwordHashed = $userExists['password'];

    $checkPassword = password_verify($password, $passwordHashed);

    if (!$checkPassword) {
        header("location: ../../../login/index.php?error=wrongpassword");
        exit();
    } else if ($checkPassword) {
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION['id'] = $userExists['id'];
        $_SESSION['email'] = $userExists['email'];

        if ($_SESSION['id'] === 1) {
            header("Location: ../../../admin");
            exit();
        }

        header("location: ../../../index.php");
        exit();
    }
}

// Purchase products
function purchase($link, $productData, $sesID)
{
    // Address variables
    $address = $_POST['address'];
    $zip_code = $_POST['zip-code'];
    $place = $_POST['place'];

    // Insert into orders table
    $insertOrderQuery = "INSERT INTO orders (user_id, total_cost, address, zip_code, place) VALUES (?, ?, ?, ?, ?)";
    $stmtOrder = mysqli_prepare($link, $insertOrderQuery);

    if ($stmtOrder) {
        mysqli_stmt_bind_param($stmtOrder, "idsss", $sesID, $totalCost, $address, $zip_code, $place);
        if (mysqli_stmt_execute($stmtOrder)) {
            // Get ID of this new order
            $orderId = mysqli_insert_id($link);

            foreach ($productData as $product) {
                $productID = $product['product_id'];
                $quantity = $product['quantity'];
                $price = $product['price'];

                // Insert into order_products table
                $insertProductQuery = "INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmtProduct = mysqli_prepare($link, $insertProductQuery);

                if ($stmtProduct) {
                    mysqli_stmt_bind_param($stmtProduct, "iiid", $orderId, $productID, $quantity, $price);
                    if (mysqli_stmt_execute($stmtProduct)) {
                        mysqli_stmt_close($stmtProduct);
                    } else
                        echo "Błąd podczas wykonywania zapytania produktu: " . mysqli_error($link);
                } else
                    echo "Błąd przygotowania zapytania produktu: " . mysqli_error($link);
            }
        } else
            echo "Błąd podczas wykonywania zapytania zamówienia: " . mysqli_error($link);

        mysqli_stmt_close($stmtOrder);
    } else
        echo "Błąd przygotowania zapytania zamówienia: " . mysqli_error($link);
}
