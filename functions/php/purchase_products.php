<?php

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
