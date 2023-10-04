<?php
session_start();

$sesID = $_SESSION['id'];
require("db_connect.php");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Scam and Run</title>
  <link rel="icon" href="./public/src/logo.png">

  <link rel="stylesheet" href="./public/styles/main.css" />
  <link rel="stylesheet" href="./public/styles/index.css" />

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2534586073857624" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="logo"><a href="./index.php">Scam and Run</a></div>
    <div class="nav-container">
      <ul class="nav-links">
        <?php
        if ($sesID === 1)
          echo '<li><a href="./admin" class="nav-link">Panel admina</a></li>';
        ?>
        <li><a href="./index.php" class="nav-link">Strona główna</a></li>
        <li><a href="./reviews" class="nav-link">Opinie</a></li>
        <li><a href="./contact" class="nav-link">Kontakt</a></li>
        <li><a href="./about" class="nav-link">O nas</a></li>
        <li></li>
        <li>
          <?php
          if (!isset($_SESSION["email"])) {
            echo '<a href="./login" class="nav-link"><img src="./public/src/cart.png" alt="Twój koszyk"></a>';
          } else
            echo '<a href="./cart" class="nav-link"><img src="./public/src/cart.png" alt="Twój koszyk"></a>';
          ?>
        </li>
        <li></li>

        <?php
        if (!isset($_SESSION["email"])) {
          echo '<li><a class="nav-link" href="./login">Logowanie </a></li>';
          echo '<li><a class="nav-link" href="./registration">Rejestracja</a></li>';
        } else
          echo '<li><a class="nav-link" href="./logout">Wyloguj</a></li>';
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
    <div class="left">
      <img src="./public/src/logo.png" alt="Logo">
    </div>
    <div class="header">
      <h1>Scam & Run</h1>
    </div>
  </div>

  <div class="products">
    <h2>Nasze produkty:</h2>
    <?php
    $sql = "SELECT id, product_name, price, photo FROM products;";

    $product = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_array($product)) {
      echo "<div class='product'>";
      echo "<a href='./products?id=" . $row['id'] . "'>";
      echo "<div class='img'><img src='" . $row['photo'] . "'>";
      echo "<h3>" . $row['price'] . " PLN</h3>";
      echo "</div>";
      echo "<div class='description'>";
      echo "<h3>" . $row['product_name'] . "</h3>";
      echo "</a>";
      echo "</div>";
      echo "</div>";
    }
    ?>
  </div>

  <script src="./public/functions/js/navbar.js"></script>
</body>

</html>