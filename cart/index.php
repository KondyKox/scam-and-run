<?php
session_start();

$sesID = $_SESSION['id'];
require("../db_connect.php");

// Adding to cart
if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Check if item is already in cart
    $isInCart = "SELECT product_id FROM cart WHERE user_id = ? AND product_id = ?;";
    $stmt = mysqli_prepare($link, $isInCart);
    mysqli_stmt_bind_param($stmt, 'ii', $sesID, $productID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $cartProductID);
    mysqli_stmt_close($stmt);

    if ($cartProductID === null) {
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
            header("Location: ../cart");
            exit();
        } else {
            // Obsługa błędu, gdy zapytanie się nie powiedzie
            die("Błąd w zapytaniu SQL: " . mysqli_error($link));
        }
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
    <link rel="icon" href="../public/src/logo.png">

    <link rel="stylesheet" href="../public/styles/main.css" />
    <link rel="stylesheet" href="../public/styles/cart.css" />

    <script src="../public/functions/js/jquery-3.7.0.min.js"></script>
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
                <li><a href="./cart" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a></li>
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

    <div class="container">
        <form action="order.php" method="post">
            <?php
            $getProducts = "SELECT products.id, products.product_name, products.photo, cart.quantity, cart.total_price
                            FROM cart INNER JOIN products ON cart.product_id = products.id WHERE user_id = ?;";

            $stmt = mysqli_prepare($link, $getProducts);
            mysqli_stmt_bind_param($stmt, 'i', $sesID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $id, $product_name, $photo, $quantity, $total_price);

            $totalCost = 0;
            $isEmpty = true;

            while (mysqli_stmt_fetch($stmt)) {
                echo "<div class='product'>";
                echo "<img src='." . $photo . "'>";
                echo "<h4>" . $product_name . "</h4>";
                echo "<div class='details'>";
                echo "<input type='number' value='" . $quantity . "' class='quantity' name='quantity_product_" . $id . "' data-product-id='" . $id . "' min='1' max='10'>";
                echo "<h4 class='price'>" . $total_price . " PLN</h4>";
                echo "</div>";
                echo "<button class='delete' type='button' data-product-id='" . $id . "'><img src='../src/trash.png' alt='Usuń z koszyka'></button>";
                echo "<input type='hidden' name='price_product_" . $id . "' value='" . $total_price . "'>";
                echo "</div>";

                $totalCost += $total_price;
                $isEmpty = false;
            }

            mysqli_stmt_close($stmt);

            echo "<div class='total'>";
            if ($isEmpty)
                echo "<h1>Twój koszyk jest pusty :(</h1>";
            else
                echo "<input type='submit' class='buy' name='buy'>";
            echo "</div>"
            ?>

            <input type='hidden' name='total_cost' value='<?php echo $totalCost; ?>'>
        </form>


    </div>

    <script src="../public/functions/js/navbar.js"></script>
    <script src="../public/functions/js/cart.js"></script>
</body>

</html>