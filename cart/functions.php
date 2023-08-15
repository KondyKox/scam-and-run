<?php
session_start();
require("../config.php");

// $sesID = $_SESSION['id'];
$sesID = 1;

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $productID = $_POST['productID'];

    // Get basic price of item
    if ($action === 'getPrice') {
        $sql = "SELECT product_price FROM cart WHERE product_id = ? AND user_id = ?;";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $productID, $sesID);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            // Obsługa błędu
            echo "Wystąpił błąd przy pobieraniu ceny produktu.";
        }

        mysqli_stmt_close($stmt);
    }

    // Change amount of item
    if ($action === 'changeAmount') {
        $newAmount = $_POST['newAmount'];

        $sql = "UPDATE cart SET amount = ?, total_price = amount * product_price WHERE product_id = ? AND user_id = ?;";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $newAmount, $productID, $sesID);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            // Obsługa błędu
            echo "Wystąpił błąd przy aktualizacji ilości.";
        }

        mysqli_stmt_close($stmt);
    }
    // Delete item from cart
    elseif ($action === 'deleteItem') {
        $sql = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $productID, $sesID);
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            // Obsługa błędu
            echo "Wystąpił błąd przy usuwaniu przedmiotu z koszyka.";
        }

        mysqli_stmt_close($stmt);
    }
}
