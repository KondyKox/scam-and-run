<?php
session_start();

$sesID = $_SESSION['id'];
require("../db_connect.php");
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
  <link rel="stylesheet" href="../public/styles/products.css" />

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
        <li>
          <?php
          if (!isset($_SESSION["email"])) {
            echo '<a href="../login" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a>';
          } else
            echo '<a href="../cart" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a>';
          ?>
        </li>
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
    <?php
    $productID = $_GET['id'];

    $sql = "SELECT product_name, price, photo, description FROM products WHERE id = $productID;";

    $product = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_array($product)) {
      echo "<div class='img'><img src='." . $row['photo'] . "'></div>";
      echo "<div class='product-container'>";
      echo "<div class='description'>";
      echo "<h2>" . $row['product_name'] . "</h2>";
      echo "<p>" . $row['description'] . "</p>";
      echo "</div>";
      echo "<div class='buyBtn'><a href='../cart?id=" . $productID . "'><input type='submit' value='Dodaj do koszyka. Cena: " . $row['price'] . " PLN' /></a></div>";
      echo "</div>";
    }

    ?>
  </div>

  <script src="../public/functions/js/navbar.js"></script>
</body>

</html>