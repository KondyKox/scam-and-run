<?php
session_start();
require_once("../../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sesID = $_SESSION['id'];

    if (isset($_POST['productID']) && isset($_POST['newQuantity'])) {
        $productID = $_POST['productID'];
        $newQuantity = $_POST['newQuantity'];

        // Zaktualizuj ilość produktu i cenę w jednym zapytaniu
        $updateQuery = "UPDATE cart AS c
                        INNER JOIN products AS p ON c.product_id = p.id
                        SET c.quantity = ?, c.total_price = (p.price * ?)
                        WHERE c.user_id = ? AND c.product_id = ?";

        $stmt = mysqli_prepare($link, $updateQuery);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iiii", $newQuantity, $newQuantity, $sesID, $productID);
            if (mysqli_stmt_execute($stmt)) {
                // Sukces w aktualizacji ilości i ceny
                echo json_encode(['success' => true, 'message' => 'Aktualizacja produktu zakończona sukcesem.']);
            } else {
                // Błąd w aktualizacji
                echo json_encode(['success' => false, 'message' => 'Błąd w aktualizacji produktu.']);
            }
            mysqli_stmt_close($stmt);
        } else {
            // Błąd w przygotowaniu zapytania
            echo json_encode(['success' => false, 'message' => 'Błąd w przygotowaniu zapytania SQL.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Brak wymaganych danych.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Nieprawidłowe żądanie.']);
}
