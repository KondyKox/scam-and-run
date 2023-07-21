<?php
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("location: ../login");
        exit;
    }

    $sesID = $_SESSION['id'];
    require("../config.php");

    $review = $_POST['#review'];
    $rating = $_POST['#rating'];

    $addReview = "INSERT INTO reviews VALUES (, $sesID, $review, $rating);";

    mysqli_query($link, $addReview);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Scam and Run</title>

  <link rel="stylesheet" href="../main.css" />
</head>

<body>
  <nav class="navbar" id="navbar">
    <div class="logo"><a href="../index.php">Scam and Run</a></div>

    <ul class="nav-links">
      <li><a href="../index.php" class="nav-link">Strona główna</a></li>
      <li><a href="index.php" class="nav-link">Opinie</a></li>
      <li><a href="../contact" class="nav-link">Kontakt</a></li>
      <li><a href="../about" class="nav-link">O nas</a></li>
      <li></li>

      <li>
        <?php
        if (!isset($_SESSION["username"])) {
          echo '<a href="../login">Logowanie </a>';
          echo '<a href="../registration">Rejestracja</a>';
        } else
          echo '<a href="../logout">Wyloguj</a>';
        ?>
      </li>
    </ul>

    <div class="burger">
      <div class="line1"></div>
      <div class="line2"></div>
      <div class="line3"></div>
    </div>
  </nav>

  <h2>Dodaj recenzję</h2>
  <form action="add_review.php" method="post" id="review-form">
    <div>
        <label for="rating">Rating:</label>
        <input type="number" id="rating" min="1" max="5" required>
    </div>
    <div>
        <label for="review">Review</label>
        <textarea id="review" required></textarea>
    </div>
    <input type="submit" value="Dodaj recenzję">
  </form>

  <script src="../navbar.js"></script>
</body>

</html>