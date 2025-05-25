<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../home.html");
    exit;
} elseif (!isset($_SESSION["loggedin"]) && isset($_COOKIE["remember_me"])) {
    $_SESSION["loggedin"] = true;
    $_SESSION["id_persona"] = $_COOKIE["remember_me"];
    header("location: ../home.html");
    exit;
}

include_once '../../config/database.php';
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
        $sql = "SELECT id_persona, mail, password, ruolo FROM persone WHERE mail = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_mail);
            $param_mail = $mail;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id_persona, $mail, $hashed_password, $ruolo);
                    if (mysqli_stmt_fetch($stmt)) {
                        $calculated_hash = hash('sha256', $password);
                        if ($calculated_hash === $hashed_password) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id_persona"] = $id_persona;
                            $_SESSION["mail"] = $mail;
                            $_SESSION["ruolo"] = $ruolo; // dove $ruolo è il valore numerico o stringa del ruolo

                            // Se l'utente vuole rimanere connesso, imposta un cookie valido per 30 giorni
                            if (isset($_POST['remember'])) {
                                setcookie("remember_me", $id_persona, time() + (86400 * 30), "/");
                            } else {
                                setcookie("remember_me", "", time() - 3600, "/");
                            }

                            header("location: ../home.html");
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
