<?php
session_start();

$sesID = $_SESSION['id'];
require("../config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['productID'])) {
    header('Content-Type: application/json');

    // Pobierz productID z żądania AJAX
    $productID = $_POST['productID'];

    $getPrice = "SELECT price FROM products WHERE id = $productID;";
    $result = mysqli_query($link, $getPrice);

    $row = mysqli_fetch_assoc($result);
    $productPrice = $row['price'];

    // Wykonaj zapytanie do dodania danych do tabeli "cart"
    $addToCart = "INSERT INTO cart (user_id, product_id, product_price) VALUES ($sesID, $productID, $productPrice)";

    if ($mysqli->query($addToCart) === TRUE) {
      echo json_encode("Dodano do koszyka");
    } else {
      echo "Błąd dodawania produktu do koszyka: " . $mysqli->error;
    }
  } else {
    echo "Błąd: Nieprawidłowe dane.";
  }
} else {
  echo "Błąd: Nieprawidłowy typ żądania.";
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
  <link rel="stylesheet" href="./style.css" />

  <!-- <script src="https://code.jquery.com/jquery-3.7.0.slim.js" integrity="sha256-7GO+jepT9gJe9LB4XFf8snVOjX3iYNb0FHYr5LI1N5c=" crossorigin="anonymous"></script> -->
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
      echo "<div class='buyBtn'><a href='../cart?id=" . $productID . "?price=" . $row['price'] . "'><input type='submit' value='Dodaj do koszyka. Cena: " . $row['price'] . " PLN' /></a></div>";
      // echo "<div class='buyBtn'><form method='post'><button type='button' id='addToCartBtn'>Dodaj do koszyka. Cena: " . $row['price'] . " PLN</button></form></div>";
      echo "</div>";
    }

    ?>
  </div>

  <script src="../navbar.js"></script>
  <!-- <script src="./add_to_cart.js"></script> -->
</body>

</html>