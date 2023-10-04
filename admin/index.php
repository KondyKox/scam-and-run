<?php
session_start();

$sesID = $_SESSION['id'];
require("../db_connect.php");

if ($sesID !== 1) {
  header("Location: ../index.php");
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
  <link rel="stylesheet" href="../public/styles/admin.css" />

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
          echo '<a href="../cart" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a>';
          ?>
        </li>
        <li></li>

        <?php
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
    <div class="admin-panel">
      <h1>Panel admina</h1>
      <form action="../public/functions/php/add_product.php" method="post">
        <div class="admin__input">
          <label for="product_name">Nazwa produktu:</label>
          <input class="btn" type="text" name="product_name" required>
        </div>
        <div class="admin__input">
          <label for="product_price">Cena produktu:</label>
          <input class="btn" type="number" name="product_price" step="1" required>
        </div>
        <div class="admin__input">
          <label for="odpruct_description">Opis produktu:</label>
          <input class="btn" type="text" name="product_description" required>
        </div>
        <div class="admin__input">
          <label for="product_img">Zdjęcie produktu:</label>
          <input class="btn" type="file" name="product_img" accept="image/*" required>
        </div>
        <input class="btn submit" type="submit" value="Dodaj produkt">
      </form>
    </div>
  </div>

  <script src="../public/functions/js/navbar.js"></script>
</body>

</html>