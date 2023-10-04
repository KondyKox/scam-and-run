<?php
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

function redirectToPayPal($link, $productData, $sesID, $address, $zip_code, $place)
{
    if (isset($response['id'])) {
        $paymentId = $response['id'];
        $approvalUrl = $response['links'][1]['href'];

        $_SESSION['order_data'] = array(
            'address' => $address,
            'zip_code' => $zip_code,
            'place' => $place,
        );

        header("Location: $approvalUrl");
    } else {
        echo "Błąd tworzenia płatności PayPal.";
    }
}

function handlePaymentSuccess($link, $productData, $sesID, $address, $zip_code, $place)
{
    $currency = 'PLN';

    $insertOrderQuery = "INSERT INTO orders (user_id, total_cost, address, zip_code, place) VALUES (?, ?, ?, ?, ?)";
    $stmtOrder = mysqli_prepare($link, $insertOrderQuery);

    if ($stmtOrder) {
        mysqli_stmt_bind_param($stmtOrder, "idsss", $sesID, $totalCost, $address, $zip_code, $place);
        if (mysqli_stmt_execute($stmtOrder)) {
            $orderId = mysqli_insert_id($link);

            foreach ($productData as $product) {
                $productID = $product['product_id'];
                $quantity = $product['quantity'];
                $price = $product['price'];

                $insertProductQuery = "INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $stmtProduct = mysqli_prepare($link, $insertProductQuery);

                if ($stmtProduct) {
                    mysqli_stmt_bind_param($stmtProduct, "iiid", $orderId, $productID, $quantity, $price);
                    if (mysqli_stmt_execute($stmtProduct)) {
                        mysqli_stmt_close($stmtProduct);
                    } else {
                        echo "Błąd podczas wykonywania zapytania produktu: " . mysqli_error($link);
                    }
                } else {
                    echo "Błąd przygotowania zapytania produktu: " . mysqli_error($link);
                }
            }
        } else {
            echo "Błąd podczas wykonywania zapytania zamówienia: " . mysqli_error($link);
        }

        mysqli_stmt_close($stmtOrder);
    } else {
        echo "Błąd przygotowania zapytania zamówienia: " . mysqli_error($link);
    }
}
