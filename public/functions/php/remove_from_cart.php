<?php
session_start();
require_once("../../../db_connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sesID = $_SESSION['id'];
    $productID = $_POST['productID'];

    $deleteQuery = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($link, $deleteQuery);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $sesID, $productID);
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
