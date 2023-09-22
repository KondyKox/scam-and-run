<?php
session_start();

$sesID = $_SESSION['id'];
require("../../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['productID']) && isset($_POST['newAmount'])) {
        $productID = $_POST['productID'];
        $newAmount = $_POST['newAmount'];

        // Funkcja do aktualizacji ceny produktu w koszyku
        function updatePrice($link, $sesID, $productID, $newAmount)
        {
            // Zabezpieczenie przed SQL Injection
            $getPriceQuery = "SELECT price FROM products WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $getPriceQuery)) {
                mysqli_stmt_bind_param($stmt, "i", $productID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $productPrice);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
            } else {
                // Obsługa błędu, gdy zapytanie się nie powiedzie
                echo json_encode(['success' => false, 'message' => 'Błąd w zapytaniu SQL: ' . mysqli_error($link)]);
                exit();
            }

            // Oblicz nową cenę
            $newPrice = $productPrice * $newAmount;

            // Zabezpieczenie przed SQL Injection
            $updatePriceQuery = "UPDATE cart SET total_price = ? WHERE user_id = ? AND product_id = ?";
            if ($stmt = mysqli_prepare($link, $updatePriceQuery)) {
                mysqli_stmt_bind_param($stmt, "iii", $newPrice, $sesID, $productID);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                echo json_encode(['success' => true, 'message' => 'Cena produktu została zaktualizowana.']);
                exit();
            } else {
                // Obsługa błędu, gdy zapytanie się nie powiedzie
                echo json_encode(['success' => false, 'message' => 'Błąd w zapytaniu SQL: ' . mysqli_error($link)]);
                exit();
            }
        }

        // Wywołanie funkcji do aktualizacji ceny
        updatePrice($link, $sesID, $productID, $newAmount);
    } else {
        echo json_encode(['success' => false, 'message' => 'Brak wymaganych danych.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nieprawidłowe żądanie.']);
    exit();
}
