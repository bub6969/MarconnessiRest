<?php
session_start();
header("Content-Type: application/json");

include_once(__DIR__ . '/../../config/database.php');

$database = new Database();
$conn = $database->getConnection();

$id_professore = $_SESSION['id_persona'] ?? null;

if (!$id_professore) {
    http_response_code(403);
    echo json_encode(["error" => "Accesso non autorizzato"]);
    exit;
}

$sql = "
SELECT
    s.giorno,
    l.ora_lezione,
    m.nome_materia,
    a.aula,
    c.classe
FROM insegna i
JOIN lezioni l ON i.id_lezione = l.id_lezione
JOIN settimana s ON l.giorno_lezione = s.id_giorno
JOIN materie m ON l.id_materia = m.id_materia
JOIN aule a ON l.id_aula = a.id_aula
JOIN classi c ON l.id_classe = c.id_classe
WHERE i.id_professore = ?
ORDER BY l.giorno_lezione, l.ora_lezione;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_professore);
$stmt->execute();
$result = $stmt->get_result();

$orario = [];

while ($row = $result->fetch_assoc()) {
    $giorno = $row['giorno'];
    if (!isset($orario[$giorno])) $orario[$giorno] = [];
    $orario[$giorno][] = [
        "ora" => $row['ora_lezione'],
        "materia" => $row['nome_materia'],
        "aula" => $row['aula'],
        "classe" => $row['classe']
    ];
}

$stmt->close();
$conn->close();

echo json_encode($orario);
