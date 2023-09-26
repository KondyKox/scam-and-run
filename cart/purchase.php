<?php
session_start();

$sesID = $_SESSION['id'];
require("../config.php");

if (isset($_GET['products'])) {
    $products = json_decode($_GET['products'], true);

    // Przekaż dane do sesji, aby były dostępne na stronie zakupu
    $_SESSION['purchase_products'] = $products;
}

if (array_key_exists('buy', $_POST))
    purchase();

function purchase()
{
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Scam and Run</title>
    <link rel="icon" href="../src/logo.png">

    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/cart.css" />

    <script src="./getCookie.js"></script>
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
                <li><a href="../cart" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a></li>
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
                    <span class="invalid-feedback"></span>
                    <label>Adres</label>
                </div>

                <div class="txtField place">
                    <input type="text" name="zip-code" required>
                    <span class="invalid-feedback"></span>
                    <label>Kod pocztowy</label>
                </div>

                <div class="txtField place">
                    <input type="text" name="place" required>
                    <span class="invalid-feedback"></span>
                    <label>Miejscowość</label>
                </div>

                <div class="txtField">

                </div>

                <div class="txtField no-border">
                    <input type="submit" value="ZAMÓW" class="order">
                </div>
            </form>
        </div>
    </div>

    <script src="../functions/js/navbar.js"></script>
</body>

</html>