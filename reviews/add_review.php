<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: ../login");
  exit;
}

$sesID = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once '../config.php';

  $review = mysqli_real_escape_string($link, $_POST['review']);
  $rating = mysqli_real_escape_string($link, $_POST['rating']);

  $addReviewQuery = "INSERT INTO reviews (user_id, text, rating) VALUES (?, ?, ?)";

  $stmt = mysqli_prepare($link, $addReviewQuery);
  mysqli_stmt_bind_param($stmt, 'iss', $sesID, $review, $rating);

  if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true, 'message' => 'Recenzja została dodana.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Wystąpił błąd podczas dodawania recenzji.']);
  }

  mysqli_stmt_close($stmt);
  mysqli_close($link);
}
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
        <li>
          <?php
          if (!isset($_SESSION["username"])) {
            echo '<a href="../login" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a>';
          } else
            echo '<a href="../cart" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a>';
          ?>
        </li>
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
    <input type="submit" class="add" value="Dodaj recenzję">
  </form>

  <script src="../navbar.js"></script>
</body>

</html>