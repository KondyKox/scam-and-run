<?php
require_once("../../../db_connect.php");

$name = $_POST['product_name'];
$price = $_POST['product_price'];
$description = $_POST['product_description'];

$uploadDir = "../public/src";
$uploadedFile = $uploadDir . '/' . basename($_FILES['product_img']['name']);

if (move_uploaded_file($_FILES['product_img']['tmp_name'], $uploadedFile)) {
    $insertQuery = "INSERT INTO products (product_name, price, photo, description) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $insertQuery);

    if ($stmt) {
        $photoURL = '../public/src/' . basename($_FILES['product_img']['name']);
        mysqli_stmt_bind_param($stmt, "sdss", $name, $price, $photoURL, $description);
        if (mysqli_stmt_execute($stmt))
            echo "Produkt został dodany!";
        else
            echo "Błąd podczas wstawiania danych produktu: " . mysqli_error($link);

        mysqli_stmt_close($stmt);
    } else
        echo "Błąd przygotowania zapytania produktu: " . mysqli_error($link);
} else
    echo "Błąd podczas przesyłania pliku.";
