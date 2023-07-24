<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../index.php");
    exit;
}

require_once "../config.php";
$sesID = $_SESSION['id'];

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: ../index.php");
                        } else {
                            $login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                        }
                    }
                } else {
                    $login_err = "Nieprawidłowa nazwa użytkownika lub hasło.";
                }
            } else {
                echo "Spróbuj ponownie później";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>

<head lang="pl">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scam and Run</title>

    <link rel="stylesheet" href="../main.css" />
    <link rel="stylesheet" href="../login.css" />
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
                <li><a href="../basket" class="nav-link"><img src="./src/koszyk.png" alt="Twój koszyk"></a></li>
                <li></li>

                <?php
                if (!isset($_SESSION["username"])) {
                    echo '<li><a class="nav-link" href="./login">Logowanie </a></li>';
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
            <form action="index.php" method="post">
                <h2>Logowanie</h2>
                <div class="txtField">
                    <input type="text" name="username" required
                        class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $username; ?>">
                    <span class="invalid-feedback">
                        <?php echo $username_err; ?>
                    </span>
                    <label>Login</label>
                </div>
                <div class="txtField">
                    <input type="password" name="password" required
                        class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $password; ?>">
                    <span class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </span>
                    <label>Hasło</label>
                </div>
                <br><br>
                <div class="txtField registration">
                    <input type="submit" value="Zaloguj się">
                </div>
                <p style="text-align: center;">Nie masz konta? <a href="../registration">Zarejestruj się tutaj</a>.</p>
            </form>
        </div>

        <script src="../navbar.js"></script>
</body>

</html>