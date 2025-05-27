<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // This redirect seems correct if this file is in pages/CambiaPassword/
    header("Location: ../Login/login.php"); // Assuming Login is in pages/Login/ from here
    exit;
}

require_once "../../config/database.php"; // This path indicates this script is likely in pages/something/
$database = new Database();
$conn = $database->getConnection();

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = trim($_POST["old_password"] ?? "");
    $new_password = trim($_POST["new_password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Tutti i campi sono obbligatori.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Le nuove password non coincidono.";
    } else {
        $id_persona = $_SESSION["id_persona"];
        $sql = "SELECT password FROM persone WHERE id_persona = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_persona);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        if ($stmt->fetch()) {
            $stmt->close();
            if (hash('sha256', $old_password) === $hashed_password) {
                $new_hashed = hash('sha256', $new_password);
                $update = $conn->prepare("UPDATE persone SET password = ? WHERE id_persona = ?");
                $update->bind_param("si", $new_hashed, $id_persona);
                if ($update->execute()) {
                    // Distruggi la sessione e reindirizza al login
                    session_unset();
                    session_destroy();
                    
                    // --- FIX IS HERE ---
                    // Corrected path to login.php from a sub-sub-directory like pages/CambiaPassword/
                    header("Location: ../../pages/Login/login.php?password=changed"); // <--- THIS LINE IS CHANGED
                    // --- END FIX ---
                    
                    exit;
                } else {
                    $error = "Errore nell'aggiornamento della password.";
                }
                $update->close();
            } else {
                $error = "La password attuale non è corretta.";
            }
        } else {
            $error = "Utente non trovato.";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Cambia Password</title>
    <link rel="stylesheet" href="../../assets/style-login-page.css">
</head>
<body>
<div class="container">
    <h2>Cambia Password</h2>
    <?php if ($success): ?>
        <div style="color:green;"><?php echo htmlspecialchars($success); ?></div>
    <?php elseif ($error): ?>
        <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label>Password attuale</label>
            <input type="password" name="old_password" required>
        </div>
        <div class="form-group">
            <label>Nuova password</label>
            <input type="password" name="new_password" required>
        </div>
        <div class="form-group">
            <label>Conferma nuova password</label>
            <input type="password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Cambia Password" class="btn-primary">
        </div>
    </form>
    <a href="../home.php">Torna alla Home</a>
</div>
</body>
</html>