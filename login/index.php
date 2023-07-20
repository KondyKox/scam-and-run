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
        <div class="logo">Scam and Run</div>

        <ul class="nav-links">
            <li><a href="../index.php">Strona główna</a></li>
            <li><a href="#">Opinie</a></li>
            <li><a href="#">Kontakt</a></li>
            <li><a href="#">O nas</a></li>
            <li></li>

            <li>
                <?php
                if (!isset($_SESSION["username"])) {
                    echo '<a href="../login">Logowanie</a>';
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
                    <input type="submit" class="button" value="Zaloguj się">
                </div>
                <p style="text-align: center;">Nie masz konta? <a href="../registration">Zarejestruj się tutaj</a>.</p>
            </form>
        </div>

        <script src="../navbar.js"></script>
</body>

</html>