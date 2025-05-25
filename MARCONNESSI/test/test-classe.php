<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/classe.php';

$database = new Database();
$db = $database->getConnection();
$classe = new Classe($db);

// 1. Test creazione classe
echo "<h3>Test: Creazione Classe</h3>";
$classe->classe = "Classe Test " . rand(1, 10000);

if ($classe->createClasse()) {
    echo "Classe creata correttamente con id: {$classe->id_classe}<br>";
} else {
    echo "Errore nella creazione della classe.<br>";
}

// 2. Test eliminazione classe appena creata
echo "<h3>Test: Eliminazione Classe</h3>";
if ($classe->deleteClasse()) {
    echo "Classe eliminata correttamente.<br>";
} else {
    echo "Errore nell'eliminazione della classe.<br>";
}

// 3. Test lettura classi
echo "<h3>Test: Lettura Classi</h3>";
$result = $classe->read();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_classe']} | Nome: {$row['classe']}<br>";
    }
} else {
    echo "Nessuna classe trovata.<br>";
}
?>