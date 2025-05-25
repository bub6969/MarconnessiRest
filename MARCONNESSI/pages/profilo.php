<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    http_response_code(401);
    exit;
}
require_once "../config/database.php";
$database = new Database();
$conn = $database->getConnection();

$id_persona = $_SESSION["id_persona"];
$sql = "SELECT nome, cognome, mail, data_nascita, ruolo FROM persone WHERE id_persona = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_persona);
$stmt->execute();
$stmt->bind_result($nome, $cognome, $mail, $data_nascita, $ruolo);
$stmt->fetch();
$stmt->close();
$conn->close();

$ruoli = [1 => "Admin", 2 => "Docente", 3 => "Studente"];
$ruolo_testo = isset($ruoli[$ruolo]) ? $ruoli[$ruolo] : "Sconosciuto";

if (isset($_GET['json'])) {
    header('Content-Type: application/json');
    echo json_encode([
        "nome" => $nome,
        "cognome" => $cognome,
        "mail" => $mail,
        "data_nascita" => $data_nascita,
        "ruolo" => $ruolo_testo
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Profilo Utente</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; font-family: 'Roboto', sans-serif; background-color: #f0f4f8; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 0 16px 2px rgba(0,51,102,0.10); padding: 32px 40px; }
        h1 { font-family: 'Montserrat', sans-serif; color: #003366; font-size: 32px; margin-bottom: 24px; }
        .profile-info { font-size: 20px; color: #333; margin-bottom: 16px; }
        .profile-label { font-weight: bold; color: #007acc; }
        .logout-btn { display: inline-block; margin-top: 24px; padding: 10px 24px; background: #007acc; color: #fff; border: none; border-radius: 6px; font-size: 18px; cursor: pointer; text-decoration: none; transition: background 0.2s; }
        .logout-btn:hover { background: #005b99; }
    </style>
</head>
<body>
<div class="container">
    <h1>Profilo Utente</h1>
    <div class="profile-info"><span class="profile-label">Nome:</span> <?php echo htmlspecialchars($nome); ?></div>
    <div class="profile-info"><span class="profile-label">Cognome:</span> <?php echo htmlspecialchars($cognome); ?></div>
    <div class="profile-info"><span class="profile-label">Email:</span> <?php echo htmlspecialchars($mail); ?></div>
    <div class="profile-info"><span class="profile-label">Data di nascita:</span> <?php echo htmlspecialchars($data_nascita); ?></div>
    <div class="profile-info"><span class="profile-label">Ruolo:</span> <?php echo htmlspecialchars($ruolo_testo); ?></div>
    <a href="../logout.php" class="logout-btn">Logout</a>
</div>
</body>
</html>
