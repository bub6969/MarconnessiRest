<?php
session_start(); // This is the ONLY session_start() you need in this file.

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // If already logged in, redirect to home.php
    header("location: ../home.php");
    exit;
} elseif (!isset($_SESSION["loggedin"]) && isset($_COOKIE["remember_me"])) {
    // Handle "remember me" functionality
    $_SESSION["loggedin"] = true;
    $_SESSION["id_persona"] = $_COOKIE["remember_me"];
    
    // IMPORTANT: When using "remember me" without a full re-login,
    // you need to retrieve 'ruolo' from the database based on 'id_persona'
    // and set it in the session before redirecting.
    
    include_once '../../config/database.php'; // Ensure this path is correct relative to login.php
    $database = new Database();
    $conn_temp = $database->getConnection(); 

    $sql_ruolo = "SELECT ruolo FROM persone WHERE id_persona = ?";
    if ($stmt_ruolo = mysqli_prepare($conn_temp, $sql_ruolo)) {
        mysqli_stmt_bind_param($stmt_ruolo, "i", $_SESSION["id_persona"]);
        mysqli_stmt_execute($stmt_ruolo);
        mysqli_stmt_bind_result($stmt_ruolo, $retrieved_ruolo);
        if (mysqli_stmt_fetch($stmt_ruolo)) {
            $_SESSION["ruolo"] = $retrieved_ruolo; // THIS IS CRUCIAL FOR "REMEMBER ME"
        }
        mysqli_stmt_close($stmt_ruolo);
    }
    mysqli_close($conn_temp); // Close temporary connection

    header("location: ../home.php");
    exit;
}

include_once '../../config/database.php'; // Ensure this path is correct
$database = new Database();
$conn = $database->getConnection(); 

$mail = $password = "";
$mail_err = $password_err = "";
$login_err = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["mail"]) || empty(trim($_POST["mail"]))) {
        $mail_err = "Inserisci la tua email.";
    } else {
        $mail = trim($_POST["mail"]);
    }

    if (!isset($_POST["password"]) || empty(trim($_POST["password"]))) {
        $password_err = "Inserisci la password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($mail_err) && empty($password_err)) {
        $sql = "SELECT id_persona, mail, password, ruolo, nome, cognome FROM persone WHERE mail = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_mail);
            $param_mail = $mail;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id_persona, $mail, $hashed_password, $ruolo, $nome, $cognome);
                    if (mysqli_stmt_fetch($stmt)) {
                        $calculated_hash = hash('sha256', $password);
                        if ($calculated_hash === $hashed_password) {
                            // Session is already started at the top of the file
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id_persona"] = $id_persona;
                            $_SESSION["mail"] = $mail;
                            $_SESSION["ruolo"] = $ruolo; // Correctly set here on successful login
                            $_SESSION["username"] = $nome." ".$cognome;

                            if (isset($_POST['remember'])) {
                                setcookie("remember_me", $id_persona, time() + (86400 * 30), "/", "", false, true); // Added secure and httponly flags
                            } else {
                                // Expire the cookie if "remember me" is not checked
                                setcookie("remember_me", "", time() - 3600, "/");
                            }

                            header("location: ../home.php");
                            exit;
                        } else {
                            $login_err = "Password errata.";
                        }
                    }
                } else {
                    $login_err = "Email o password non validi.";
                }
            } else {
                $login_err = "Errore di sistema. Riprova più tardi.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login - Marconnessi</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/style-login-page.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <p>Inserisci le credenziali per accedere.</p>

        <?php 
        if (!empty($login_err)) {
            echo '<div class="invalid-feedback" style="color:red;">' . htmlspecialchars($login_err) . '</div>'; 
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="mail" class="<?php echo (!empty($mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($mail); ?>">
                <?php if (!empty($mail_err)): ?>
                    <div class="invalid-feedback"><?php echo $mail_err; ?></div>
                <?php endif; ?>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <?php if (!empty($password_err)): ?>
                    <div class="invalid-feedback"><?php echo $password_err; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" id="remember" <?php if(isset($_POST['remember'])) echo 'checked'; ?>>
                <label for="remember">Rimani connesso</label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn-primary" value="Login">
            </div>
        </form>

        <div class="register-link">
        </div>
    </div>
</body>
</html>