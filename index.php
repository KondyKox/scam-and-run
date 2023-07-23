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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <link rel="stylesheet" href="main.css" />
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Scam and Run</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Strona główna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./reviews">Opinie</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./contact">Kontakt</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="./about">O nas</a>
        </li>

        <li class="nav-item">
        <?php
        if (!isset($_SESSION["username"])) {
          echo '<a class="nav-link" href="./login">Logowanie </a>';
          echo '<a class="nav-link" href="./registration">Rejestracja</a>';
        } else
          echo '<a class="nav-link" href="./logout">Wyloguj</a>';
        ?>
      </li>
      </ul>
    </div>
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

  <!-- <script src="navbar.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>