<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] != 1) {
    header("Location: Login/login.php");
    exit;
}
require_once "../config/database.php";
$database = new Database();
$conn = $database->getConnection();

$success = $error = "";
// CREAZIONE UTENTE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crea_utente"])) {
    $nome = trim($_POST["nome"]);
    $cognome = trim($_POST["cognome"]);
    $mail = trim($_POST["mail"]);
    $data_nascita = trim($_POST["data_nascita"]);
    $ruolo = intval($_POST["ruolo"]);
    $password = hash('sha256', $_POST["password"]);

    // Controllo mail già esistente
    $check = $conn->prepare("SELECT id_persona FROM persone WHERE mail=?");
    $check->bind_param("s", $mail);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $error = "Questa email è già registrata.";
    } else {
        $sql = "INSERT INTO persone (nome, cognome, mail, data_nascita, ruolo, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssis", $nome, $cognome, $mail, $data_nascita, $ruolo, $password);
        if ($stmt->execute()) {
            header("Location: admin-utenti.php?success=" . urlencode("Utente creato con successo!"));
            exit;
        } else {
            header("Location: admin-utenti.php?error=" . urlencode("Errore nella creazione dell'utente."));
            exit;
        }
        $stmt->close();
    }
    $check->close();
}

// MODIFICA UTENTE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifica_utente"])) {
    $id = intval($_POST["id_persona"]);
    $nome = trim($_POST["nome"]);
    $cognome = trim($_POST["cognome"]);
    $mail = trim($_POST["mail"]);
    $data_nascita = trim($_POST["data_nascita"]);
    if (!isset($_POST["ruolo"])) {
        $error = "Il ruolo è obbligatorio per la modifica!";
    } else {
        $ruolo = intval($_POST["ruolo"]);
        $sql = "UPDATE persone SET nome=?, cognome=?, mail=?, data_nascita=?, ruolo=? WHERE id_persona=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $nome, $cognome, $mail, $data_nascita, $ruolo, $id);
        if ($stmt->execute()) {
            $success = "Utente modificato con successo!";
        } else {
            $error = "Errore nella modifica dell'utente.";
        }
        $stmt->close();
    }
}

// MODIFICA PASSWORD UTENTE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cambia_password"])) {
    $id = intval($_POST["id_persona"]);
    $nuova_password = trim($_POST["nuova_password"]);
    if (!empty($nuova_password)) {
        $new_hashed = hash('sha256', $nuova_password);
        $stmt = $conn->prepare("UPDATE persone SET password=? WHERE id_persona=?");
        $stmt->bind_param("si", $new_hashed, $id);
        if ($stmt->execute()) {
            $success = "Password aggiornata con successo!";
        } else {
            $error = "Errore nell'aggiornamento della password.";
        }
        $stmt->close();
    } else {
        $error = "La nuova password non può essere vuota.";
    }
}

// ELIMINA UTENTE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["elimina_utente"])) {
    $id = intval($_POST["id_persona"]);
    $stmt = $conn->prepare("DELETE FROM persone WHERE id_persona=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Utente eliminato con successo!";
    } else {
        $error = "Errore nell'eliminazione dell'utente.";
    }
    $stmt->close();
}

// RECUPERA UTENTI
$utenti = [];
$result = $conn->query("SELECT id_persona, nome, cognome, mail, data_nascita, ruolo FROM persone");
while ($row = $result->fetch_assoc()) {
    $utenti[] = $row;
}
$conn->close();
$ruoli = [1 => "Admin", 2 => "Docente", 3 => "Studente"];
?>
<!DOCTYPE html>
<html lang="it">
<head>
     <link rel="stylesheet" href="../assets/style-admin.css">
    <meta charset="UTF-8">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="../assets/style-home.css">
</head>
<body>
   <header>
    <div class="logo">MARCONNESSI</div>
    <nav>
      <ul>
         <li><a href="Home.php">Home</a></li>
         <li><a href="ticket-admin.php">Gestione ticket</a></li>
         <li><a href="admin-utenti.php">Gestione Utenti</a></li>
         <li><a href="../logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
<div class="container">
   
    <h2>Gestione Utenti</h2>
    <?php
    $success = isset($_GET['success']) ? $_GET['success'] : '';
    $error = isset($_GET['error']) ? $_GET['error'] : '';
    ?>
    <?php if ($success): ?>
        <div style="color:green;"><?php echo htmlspecialchars($success); ?></div>
    <?php elseif ($error): ?>
        <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <h3>Crea nuovo utente</h3>
    <form method="post" class="form-inline">
        <input type="hidden" name="crea_utente" value="1">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cognome" placeholder="Cognome" required>
        <input type="email" name="mail" placeholder="Email" required>
        <input type="date" name="data_nascita" required>
        <select name="ruolo" required>
            <option value="">Ruolo</option>
            <?php foreach($ruoli as $k=>$v): ?>
                <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-admin">Crea</button>
    </form>

    <h3>Utenti esistenti</h3>
    <table class="admin-table">
        <tr>
            <th>ID</th><th>Nome</th><th>Cognome</th><th>Email</th><th>Data nascita</th><th>Ruolo</th><th>Azioni</th>
        </tr>
        <?php foreach($utenti as $utente): ?>
<tr id="row-<?php echo $utente['id_persona']; ?>">
    <td colspan="7">
        <form method="post" class="form-inline" id="form-<?php echo $utente['id_persona']; ?>" style="display:flex; align-items:center; gap:10px;">
            <input type="hidden" name="id_persona" value="<?php echo $utente['id_persona']; ?>">
            <input type="hidden" name="modifica_utente" value="1">
            <span><?php echo $utente['id_persona']; ?></span>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($utente['nome']); ?>" required readonly>
            <input type="text" name="cognome" value="<?php echo htmlspecialchars($utente['cognome']); ?>" required readonly>
            <input type="email" name="mail" value="<?php echo htmlspecialchars($utente['mail']); ?>" required readonly>
            <input type="date" name="data_nascita" value="<?php echo htmlspecialchars($utente['data_nascita']); ?>" required readonly>
            <select name="ruolo" disabled required>
                <?php foreach($ruoli as $k=>$v): ?>
                    <option value="<?php echo $k; ?>" <?php if($utente['ruolo']==$k) echo "selected"; ?>><?php echo $v; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="btn-admin" onclick="abilitaModifica(<?php echo $utente['id_persona']; ?>, this)">Modifica</button>
            <button type="submit" class="btn-admin" style="display:none;">Salva</button>
            <button type="button" class="btn-admin" onclick="mostraPassword(<?php echo $utente['id_persona']; ?>)">Cambia password</button>
            <input type="password" name="nuova_password" placeholder="Nuova password" style="display:none; margin-top:5px;">
            <button type="submit" name="cambia_password" value="1" class="btn-admin" style="display:none;">Salva password</button>
            <button type="submit" name="elimina_utente" value="1" class="btn-admin" style="background:#d32f2f; margin-left:5px;" onclick="return confirm('Sei sicuro di voler eliminare questo utente?');">Elimina</button>
        </form>
    </td>
</tr>
        <?php endforeach; ?>
    </table>
    <a href="Home.php" class="btn-home-link" style="margin-top:20px; display:inline-block;">Torna alla Home</a>
</div>
<script>
function abilitaModifica(id, btn) {
    var form = document.getElementById('form-' + id);
    var inputs = form.querySelectorAll('input, select');
    inputs.forEach(function(input) {
        if(input.name !== 'id_persona' && input.name !== 'modifica_utente' && input.name !== 'nuova_password') {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        }
    });
    btn.style.display = 'none';
    form.querySelector('button[type="submit"]').style.display = '';
}
function mostraPassword(id) {
    var form = document.getElementById('form-' + id);
    var pwd = form.querySelector('input[name="nuova_password"]');
    var salva = form.querySelector('button[name="cambia_password"]');
    pwd.style.display = '';
    salva.style.display = '';
}
</script>
</body>
</html>