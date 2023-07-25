<?php
session_start();

$sesID = $_SESSION['id'];
require('../config.php');
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
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="logo"><a href="../index.php">Scam and Run</a></div>
    <div class="nav-container">
      <ul class="nav-links">
        <li><a href="../index.php" class="nav-link">Strona główna</a></li>
        <li><a href="./index.php" class="nav-link">Opinie</a></li>
        <li><a href="../contact" class="nav-link">Kontakt</a></li>
        <li><a href="../about" class="nav-link">O nas</a></li>
        <li></li>
        <li><a href="../cart" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a></li>
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

  <div class="reviews">
  <div class="add-review">
      <a href="add_review.php"><input type="submit" class="add" value="Dodaj recenzję"></a>
    </div>
    <div class="users-reviews">
      <?php
      $sql = "SELECT reviews.text, reviews.rating, users.username FROM reviews
        INNER JOIN users ON reviews.user_id = users.id
        ORDER BY reviews.date";

      $result = mysqli_query($link, $sql);

      while ($row = $result->fetch_assoc()) {
        echo "<div class='review'>";
        echo "<div class='user'>" . $row['username'] . "</div>";
        // echo "<div class='rating'>" . $row['rating'] . "</div>";
        echo "<div class='rating'>";

        for ($i = 1; $i < $row['rating']; $i++) {
          echo "<img src='../src/star.png'>";
        }

        echo "</div>";
        echo "<div class='comment'>" . $row['text'] . "</div>";
        echo "</div>";
      }
      ?>
    </div>
  </div>

  <script src="../navbar.js"></script>
</body>

</html>