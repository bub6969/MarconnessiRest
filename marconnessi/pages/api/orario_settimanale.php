<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once(__DIR__ . '/../../config/database.php');

$database = new Database();
$conn = $database->getConnection(); // <-- Changed $db to $conn here!

// Check for connection error immediately after getting the connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Errore di connessione al database: " . $conn->connect_error]);
    exit;
}

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
    a.aula,
    pr.nome AS nome_professore,
    pr.cognome AS cognome_professore
FROM persone p
JOIN frequenta f ON p.id_persona = f.id_persona
JOIN lezioni l ON f.id_classe = l.id_classe
JOIN materie m ON l.id_materia = m.id_materia
JOIN settimana s ON l.giorno_lezione = s.id_giorno
JOIN aule a ON l.id_aula = a.id_aula
LEFT JOIN insegna i ON l.id_lezione = i.id_lezione
LEFT JOIN persone pr ON i.id_professore = pr.id_persona
WHERE p.id_persona = ?
ORDER BY s.id_giorno, l.ora_lezione;
";

$stmt = $conn->prepare($sql); // This will now work!
if (!$stmt) {
    // Handle prepare error (e.g., malformed SQL query)
    http_response_code(500);
    echo json_encode(["error" => "Errore nella preparazione della query: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id_studente);
$stmt->execute();
$result = $stmt->get_result();

$orario = [];

while ($row = $result->fetch_assoc()) {
    $giorno = $row['giorno'];
    $ora = $row['ora_lezione'];

    // Chiave univoca per la lezione
    $lezione_key = $giorno . '-' . $ora . '-' . $row['nome_materia'] . '-' . $row['aula'];

    if (!isset($orario[$giorno])) {
        $orario[$giorno] = [];
    }

    if (!isset($orario[$giorno][$lezione_key])) {
        $orario[$giorno][$lezione_key] = [
            "ora" => $ora,
            "materia" => $row['nome_materia'],
            "aula" => $row['aula'],
            "professore" => [],
        ];
    }

    $nomeProf = trim(($row['nome_professore'] ?? '') . ' ' . ($row['cognome_professore'] ?? ''));
    if ($nomeProf !== '') {
        $orario[$giorno][$lezione_key]["professore"][] = $nomeProf;
    }
}

// Converti in array finale raggruppando professori come stringa unica
foreach ($orario as $giorno => &$lezioni) {
    $lezioni = array_map(function($lezione) {
        $lezione['professore'] = implode(', ', $lezione['professore']) ?: 'N/A';
        return $lezione;
    }, array_values($lezioni));
}

echo json_encode($orario);

?>