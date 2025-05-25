<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

require_once "config.php";

$name = $password = "";
$name_err = $password_err = "";
$login_err = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["name"]))) {
        $name_err = "Inserisci il tuo nome.";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Inserisci la password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($name_err) && empty($password_err)) {
        $sql = "SELECT id, name, password FROM users WHERE name = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            $param_name = $name;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            header("location: home.php");
                            exit;
                        } else {
                            $login_err = "Password errata.";
                        }
                    }
                } else {
                    $login_err = "Nome utente o password non validi.";
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
			echo htmlspecialchars($login_err);  
		}
		?>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="name" class="<?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>">
                <?php if (!empty($name_err)): ?>
                    <div class="invalid-feedback"><?php echo $name_err; ?></div>
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
                <input type="submit" class="btn-primary" value="Login">
            </div>
        </form>

        <div class="register-link">
        </div>
    </div>
</body>
</html>
