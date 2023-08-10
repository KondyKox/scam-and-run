<?php
session_start();
require("../config.php");

$sesID = $_SESSION['id'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $productID = $_POST['productID'];

    // Change amount of item
    if ($action === 'changeAmount') {
        $newAmount = $_POST['newAmount'];

        $sql = "UPDATE cart SET amount = $newAmount WHERE product_id = $productID AND user_id = $sesID;";
        $result = mysqli_query($link, $sql);
    }
    // Delete item from cart
    elseif ($action === 'deleteItem') {
        $sql = "DELETE FROM cart WHERE product_id = $productID AND user_id = $sesID;";
        $result = mysqli_query($link, $sql);
    }
}
