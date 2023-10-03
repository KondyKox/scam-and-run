<?php
session_start();

$sesID = $_SESSION['id'];
require("../db_connect.php");

if (isset($_POST['buy'])) {
    require_once '../public/functions/php/functions.php';

    $productData = [];
    $totalCost = $_POST['total_cost'];

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity_product_') === 0) {
            $productID = str_replace('quantity_product_', '', $key);
            $quantity = $_POST[$key];
            $price = $_POST['price_product_' . $productID];

            $productData[] = [
                'product_id' => $productID,
                'quantity' => $quantity,
                'price' => $quantity * $price,
            ];
        }
    }

    if (array_key_exists('order', $_POST)) {
        $result = purchase($link, $productData, $sesID);

        if ($result)
            echo "Zamówienie zostało pomyślnie przetworzone.";
        else
            echo "Wystąpił błąd podczas przetwarzania zamówienia: " . $result;
    }
} else {
    header('Location: ../cart');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Scam and Run</title>
    <link rel="icon" href="../public/src/logo.png">

    <link rel="stylesheet" href="../public/styles/main.css" />
    <link rel="stylesheet" href="../public/styles/purchase.css" />
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="logo"><a href="../index.php">Scam and Run</a></div>
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="../index.php" class="nav-link">Strona główna</a></li>
                <li><a href="../reviews" class="nav-link">Opinie</a></li>
                <li><a href="../contact" class="nav-link">Kontakt</a></li>
                <li><a href="../about" class="nav-link">O nas</a></li>
                <li></li>
                <li><a href="../cart" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a></li>
                <li></li>

                <?php
                if (!isset($_SESSION["email"])) {
                    echo '<li><a class="nav-link" href="../login">Logowanie </a></li>';
                    echo '<li><a class="nav-link" href="../registration">Rejestracja</a></li>';
                } else
                    echo '<li><a class="nav-link" href="../logout">Wyloguj</a></li>';
                ?>
            </ul>
        </div>

        <div class="toggle-button">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </nav>

    <div class="extra">
        <div class="container">
            <form action="purchase.php" method="post" class="purchase">
                <h2>Finalizacja zakupu</h2>

                <div class="txtField">
                    <input type="text" name="address" required>
                    <label>Adres</label>
                </div>

                <div class="txtField place">
                    <input type="text" name="zip-code" required>
                    <label>Kod pocztowy</label>
                </div>

                <div class="txtField place">
                    <input type="text" name="place" required>
                    <label>Miejscowość</label>
                </div>

                <div class="txtField">
                    <?php
                    echo "<span>Całkowity koszt: $totalCost PLN</span>"
                    ?>
                </div>

                <div class="txtField no-border">
                    <input type="submit" value="ZAMÓW" class="order" name="order">
                </div>
            </form>
        </div>
    </div>

    <script src="../public/functions/js/navbar.js"></script>
</body>

</html>