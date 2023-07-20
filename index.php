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
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="logo"><a href="index.php">Scam and Run</a></div>

    <ul class="nav-links">
      <li><a href="index.php" class="active">Strona główna</a></li>
      <li><a href="#">Opinie</a></li>
      <li><a href="#">Kontakt</a></li>
      <li><a href="#">O nas</a></li>
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

  <script src="navbar.js"></script>
</body>

</html>