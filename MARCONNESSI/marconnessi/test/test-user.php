
<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// 1. Test registrazione utente
echo "<h3>Test: Registrazione Utente</h3>";
$user->mail = "test" . rand(1, 10000) . "@esempio.com";
$user->nome = "Mario";
$user->cognome = "Rossi";
$user->data_nascita = "2000-01-01";
$user->ruolo = 3; // Sostituisci con un id_ruolo valido
$user->password = "password";
$user->created = date("Y-m-d H:i:s");

if ($user->signup()) {
    echo "Utente registrato correttamente con id: {$user->id}<br>";
} else {
    echo "Errore nella registrazione dell'utente (forse già esistente).<br>";
}

// 2. Test login utente
echo "<h3>Test: Login Utente</h3>";
$user->password = "password";
$result = $user->login();
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Login riuscito per: {$row['nome']} {$row['cognome']}<br>";
} else {
    echo "Login fallito.<br>";
}

// 3. Test verifica esistenza utente
echo "<h3>Test: Esistenza Utente</h3>";
if ($user->isAlreadyExist()) {
    echo "L'utente esiste già.<br>";
} else {
    echo "L'utente non esiste.<br>";
}

// 4. Test getNome
echo "<h3>Test: getNome</h3>";
$result = $user->getNome($user->mail);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Nome: {$row['nome']}<br>";
} else {
    echo "Nome non trovato.<br>";
}

// 5. Test getCognome
echo "<h3>Test: getCognome</h3>";
$result = $user->getCognome($user->mail);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Cognome: {$row['cognome']}<br>";
} else {
    echo "Cognome non trovato.<br>";
}

// 6. Test getEmail (usa l'id appena creato)
echo "<h3>Test: getEmail</h3>";
$result = $user->getEmail($user->id);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Email: {$row['mail']}<br>";
} else {
    echo "Email non trovata.<br>";
}

// 7. Test getRuolo
echo "<h3>Test: getRuolo</h3>";
$result = $user->getRuolo($user->mail);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Ruolo: {$row['ruolo']}<br>";
} else {
    echo "Ruolo non trovato.<br>";
}

// 8. Test getOrarioByMail
echo "<h3>Test: getOrarioByMail</h3>";
$result = $user->getOrarioByMail($user->mail);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Ora: {$row['N_ora']} | Giorno: {$row['giorno']} | Materia: {$row['nome_materia']} | Aula: {$row['aula']}<br>";
    }
} else {
    echo "Nessun orario trovato per questo utente.<br>";
}
?>