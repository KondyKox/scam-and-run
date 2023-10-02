<!DOCTYPE html>

<head lang="pl">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scam and Run</title>
    <link rel="icon" href="../public/src/logo.png">

    <link rel="stylesheet" href="../public/styles/main.css" />
    <link rel="stylesheet" href="../public/styles/login.css" />
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="logo"><a href="../index.php">Scam and Run</a></div>
        <div class="nav-container">
            <ul class="nav-links">
                <li><a href="../index.php" class="nav-link">Strona główna</a></li>
                <li><a href="../index.php" class="nav-link">Opinie</a></li>
                <li><a href="../contact" class="nav-link">Kontakt</a></li>
                <li><a href="../about" class="nav-link">O nas</a></li>
                <li></li>
                <li>
                    <?php
                    if (!isset($_SESSION["email"])) {
                        echo '<a href="./index.php" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a>';
                    } else
                        echo '<a href="../cart" class="nav-link"><img src="../public/src/cart.png" alt="Twój koszyk"></a>';
                    ?>
                </li>
                <li></li>

                <?php
                if (!isset($_SESSION["email"])) {
                    echo '<li><a class="nav-link" href="./index.php">Logowanie </a></li>';
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

    <div class="extra">
        <div class="login" id="login">
            <form action="../public/functions/php/login.php" method="post">
                <h2>Logowanie</h2>
                <div class="txtField">
                    <input type="text" name="email" required class="form-control">
                    <label>Email</label>
                </div>
                <div class="txtField">
                    <input type="password" name="password" required class="form-control">
                    <label>Hasło</label>
                </div>
                <br><br>
                <div class="txtField registration">
                    <input type="submit" value="Zaloguj się" name="submit">
                </div>
                <p style="text-align: center;">Nie masz konta? <a href="../registration">Zarejestruj się tutaj</a>.</p>
            </form>
        </div>

        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyinput')
                echo "<script>alert('Nie zostawiaj pustych pól!')</script>";

            if ($_GET['error'] == 'wrongemail')
                echo "<script>alert('Niepoprawny adres email!')</script>";

            if ($_GET['error'] == 'wrongpassword')
                echo "<script>alert('Niepoprawne hasło!')</script>";
        }
        ?>

    </div>

    <script src="../public/functions/js/navbar.js"></script>
</body>

</html>