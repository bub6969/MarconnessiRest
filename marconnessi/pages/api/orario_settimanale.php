<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Connessione al database
include_once "../../../config/database.php";
 $database = new Database();
    $db = $database->getConnection();

$id_studente = $_SESSION['id_persona'] ?? null;

if (!$id_studente) {
    http_response_code(400);
    echo json_encode(["error" => "Utente non autenticato"]);
    exit;
}

$sql = "
SELECT 
    s.giorno,
    l.ora_lezione,
    m.nome_materia,
    a.aula
FROM persone p
JOIN frequenta f ON p.id_persona = f.id_persona
JOIN lezioni l ON f.id_classe = l.id_classe
JOIN materie m ON l.id_materia = m.id_materia
JOIN settimana s ON l.giorno_lezione = s.id_giorno
JOIN aule a ON l.id_aula = a.id_aula
WHERE p.id_persona = ?
ORDER BY s.id_giorno, l.ora_lezione;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_studente);
$stmt->execute();
$result = $stmt->get_result();

$orario = [];
while ($row = $result->fetch_assoc()) {
    $giorno = $row['giorno'];
    if (!isset($orario[$giorno])) {
        $orario[$giorno] = [];
    }
    $orario[$giorno][] = [
        "ora" => $row['ora_lezione'],
        "materia" => $row['nome_materia'],
        "aula" => $row['aula']
    ];
}

echo json_encode($orario);
?>
