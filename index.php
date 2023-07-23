<?php
session_start();

$sesID = $_SESSION['id'];
require("config.php");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Scam and Run</title>

  <link rel="stylesheet" href="main.css" />
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="logo"><a href="index.php">Scam and Run</a></div>

    <ul class="nav-links">
      <li><a href="index.php" class="nav-link">Strona główna</a></li>
      <li><a href="./reviews" class="nav-link">Opinie</a></li>
      <li><a href="./contact" class="nav-link">Kontakt</a></li>
      <li><a href="./about" class="nav-link">O nas</a></li>
      <li></li>

      <li>
        <?php
        if (!isset($_SESSION["username"])) {
          echo '<a href="./login">Logowanie </a>';
          echo '<a href="./registration">Rejestracja</a>';
        } else
          echo '<a href="./logout">Wyloguj</a>';
        ?>
      </li>
    </ul>

    <div class="burger">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>
  </nav>

  <div class="container">
    <div class="left">
      <img src="./src/star.png" alt="Logo">
    </div>
    <div class="header">
      <h1>Scam and Run</h1>
    </div>
  </div>

  <div class="container">
    <div class="products"></div>
  </div>

  <script src="navbar.js"></script>
</body>

</html>