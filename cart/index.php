<?php
session_start();

$sesID = $_SESSION['id'];
require("../config.php");

// Adding to cart
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

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
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }

    // Zabezpieczenie przed SQL Injection
    $addToCartQuery = "INSERT INTO cart (user_id, product_id, product_price) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $addToCartQuery)) {
        mysqli_stmt_bind_param($stmt, "iii", $sesID, $productID, $productPrice);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Przekierowanie do poprzedniej strony po dodaniu do koszyka
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // Obsługa błędu, gdy zapytanie się nie powiedzie
        die("Błąd w zapytaniu SQL: " . mysqli_error($link));
    }
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

    <link rel="stylesheet" href="../main.css" />
    <link rel="stylesheet" href="./style.css" />
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
                <li><a href="./cart" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a></li>
                <li></li>

                <?php
                if (!isset($_SESSION["username"])) {
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

    <div class="container">
        <form action="purchase.php" method="post">
            <?php
            $sql = "SELECT products.id, products.product_name, products.photo, cart.amount, cart.product_price FROM cart INNER JOIN products ON cart.product_id = products.id WHERE user_id = 1;";
            $result = mysqli_query($link, $sql);

            if ($row = mysqli_fetch_array($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class='product' data_product_id='" . $row['id'] . "'>";
                    echo "<img src='." . $row['photo'] . "'>";
                    echo "<h4>" . $row['product_name'] . "</h4>";
                    echo "<div class='details'>";
                    echo "<input type='number' value='" . $row['amount'] . "' class='amount' min='1' max='10'>";
                    echo "<h4 class='price'>" . $row['product_price'] . " PLN</h4>";
                    echo "</div>";
                    echo "<button class='delete'><img src='../src/trash.png' alt='Usuń z koszyka'></button>";
                    echo "</div>";
                }

                echo    "<div class='total'>
                        <input type='submit' class='buy'>
                        </div>
                    ";
            } else {
                echo "<div class='empty'><h1>Twój koszyk jest pusty :(</h1></div>";
            }
            ?>
        </form>
    </div>

    <script src="../navbar.js"></script>
    <script src="./function.js"></script>
</body>

</html>