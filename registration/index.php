<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scam and Run</title>
    <link rel="icon" href="../src/logo.png">

    <link rel="stylesheet" href="../styles/main.css" />
    <link rel="stylesheet" href="../styles/login.css" />
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
                        echo '<a href="../login" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a>';
                    } else
                        echo '<a href="../cart" class="nav-link"><img src="../src/cart.png" alt="Twój koszyk"></a>';
                    ?>
                </li>
                <li></li>

                <?php
                if (!isset($_SESSION["email"])) {
                    echo '<li><a class="nav-link" href="../login">Logowanie </a></li>';
                    echo '<li><a class="nav-link" href="./index.php">Rejestracja</a></li>';
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
            <form action="../functions/php/signup.php" method="post">
                <h2>REJESTRACJA</h2>
                <div class="txtField">
                    <input type="text" name="email" required class="form-control">
                    <label>Email</label>
                </div>
                <div class="txtField">
                    <input type="password" name="password" required class="form-control">
                    <label>Hasło</label>
                </div>
                <div class="txtField">
                    <input type="password" name="confirm-password" required class="form-control">
                    <label>Powtórz hasło</label>
                </div>
                <div class="txtField registration">
                    <input type="submit" value="Zarejestruj się" name="submit">
                </div>
                <p style="text-align: center;">Masz już konto? <a href="../login">Zaloguj się tutaj</a>.</p>
            </form>
        </div>

        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyinput')
                echo "<script>alert('Nie zostawiaj pustych pól!')</script>";

            if ($_GET['error'] == 'invalidemail')
                echo "<script>alert('Wpisz poprawny email!')</script>";

            if ($_GET['error'] == 'passwordsdontmatch')
                echo "<script>alert('Hasła nie są identyczne!')</script>";

            if ($_GET['error'] == 'emailtaken')
                echo "<script>alert('Email zajęty.')</script>";

            if ($_GET['error'] == 'stmtfailed')
                echo "<script>alert('Coś poszło nie tak... Spróbuj ponownie.')</script>";

            if ($_GET['error'] == 'none')
                echo "<script>alert('Udało się utworzyć konto! :D')</script>";
        }
        ?>

    </div>

    <script src="../functions/js/navbar.js"></script>
</body>

</html>