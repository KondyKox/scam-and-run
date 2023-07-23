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

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->

  <link rel="stylesheet" href="./main.css" />
  <link rel="stylesheet" href="./style.css" />
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="logo"><a href="../index.php">Scam and Run</a></div>
    <a href="#" class="toggle-button">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </a>
    <div class="nav-container">
      <ul class="nav-links">
        <li><a href="./index.php" class="nav-link">Strona główna</a></li>
        <li><a href="./reviews" class="nav-link">Opinie</a></li>
        <li><a href="./contact" class="nav-link">Kontakt</a></li>
        <li><a href="./about" class="nav-link">O nas</a></li>
        <li></li>

        <?php
        if (!isset($_SESSION["username"])) {
          echo '<li><a class="nav-link" href="./login">Logowanie </a></li>';
          echo '<li><a class="nav-link" href="./registration">Rejestracja</a></li>';
        } else
          echo '<li><a class="nav-link" href="./logout">Wyloguj</a></li>';
        ?>
      </ul>
    </div>

    <!-- <div class="burger">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div> -->
  </nav>

  <div class="container">
    <div class="left">
      <img src="./src/star.png" alt="Logo">
    </div>
    <div class="header">
      <h1>Scam and Run</h1>
    </div>
  </div>

  <div class="products">
    <div class="product">
      <img src="./src/star.png" alt="">
      <div class="description">
        <h3>tytul</h3>
        <p>jakis telksr</p>
      </div>
    </div>
    <div class="product">
      <img src="./src/star.png" alt="">
      <div class="description">
        <h3>tytul</h3>
        <p>jakis telksr</p>
      </div>
    </div>
    <div class="product">
      <img src="./src/star.png" alt="">
      <div class="description">
        <h3>tytul</h3>
        <p>jakis telksr</p>
      </div>
    </div>
    <div class="product">
      <img src="./src/star.png" alt="">
      <div class="description">
        <h3>tytul</h3>
        <p>jakis telksr</p>
      </div>
    </div>
  </div>

  <script src="navbar.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>