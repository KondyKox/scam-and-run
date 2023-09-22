<?php
session_start();
require_once("../../config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sesID = $_SESSION['id'];
    $productID = $_POST['productID'];
    $newAmount = $_POST['newAmount'];

    $updateQuery = "UPDATE cart SET amount = ? WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($link, $updateQuery);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iii", $newAmount, $sesID, $productID);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false]);
    }
}
