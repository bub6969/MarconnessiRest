<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["ruolo"] != 1) {
    header("Location: Login/login.php");
    exit;
}
include_once "../config/database.php";
include_once "../models/ticket.php";

$database = new Database();
$db = $database->getConnection();
$ticket = new Ticket($db);

// Recupera tutti i ticket
$result = $ticket->read();
$tickets_attesa = [];
$tickets_risolti = [];
while ($row = $result->fetch_assoc()) {
    if (empty($row['risposta_txt'])) {
        $tickets_attesa[] = $row;
    } else {
        $tickets_risolti[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Gestione Ticket</title>
  <link rel="stylesheet" href="../assets/style-home.css">
  <style>
    .ticket-section { margin-bottom: 40px; }
    .ticket-admin { border:1px solid #ddd; border-radius:6px; margin-bottom:18px; padding:18px; background:#fff; }
    .ticket-admin .titolo { font-weight:bold; font-size:18px; }
    .ticket-admin .data { color:#555; font-size:14px; }
    .ticket-admin .corpo { margin:10px 0; }
    .ticket-admin .risposta { background:#f4f4f4; padding:10px; border-radius:4px; margin-top:10px; }
    .rispondi-form textarea { width:100%; margin:8px 0; padding:8px; border-radius:4px; border:1px solid #ccc; }
    .rispondi-form button { background:#1976d2; color:#fff; border:none; border-radius:4px; padding:8px 18px; cursor:pointer; }
    .rispondi-form button:hover { background:#005b99; }
  </style>
</head>
<body>
  <header>
    <div class="logo">MARCONNESSI</div>
    <nav>
      <ul>
        <li><a href="Home.php">Home</a></li>
        <li><a href="ticket-admin.php">Gestione Ticket</a></li>
        <li><a href="admin-db.html">Gestione Database</a></li>
        <li><a href="admin-utenti.php">Gestione Utenti</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <div class="container">
    <h1>Gestione Ticket</h1>

    <!-- Ticket in attesa -->
    <div class="ticket-section">
      <h2>Ticket in attesa di risposta</h2>
      <?php if (count($tickets_attesa) == 0): ?>
        <p>Nessun ticket in attesa.</p>
      <?php else: ?>
        <?php foreach ($tickets_attesa as $t): ?>
          <div class="ticket-admin" id="ticket-<?php echo $t['id']; ?>">
            <div class="titolo"><?php echo htmlspecialchars($t['oggetto_domanda']); ?></div>
            <div class="data">Data: <?php echo htmlspecialchars($t['data_domanda']); ?></div>
            <div class="corpo"><?php echo nl2br(htmlspecialchars($t['domanda_txt'])); ?></div>
            <form class="rispondi-form" data-id="<?php echo $t['id']; ?>">
              <label for="risposta_<?php echo $t['id']; ?>">Risposta:</label>
              <textarea id="risposta_<?php echo $t['id']; ?>" required></textarea>
              <button type="submit">Invia Risposta</button>
              <span class="msg"></span>
            </form>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Ticket risolti -->
    <div class="ticket-section">
      <h2>Ticket completati</h2>
      <?php if (count($tickets_risolti) == 0): ?>
        <p>Nessun ticket completato.</p>
      <?php else: ?>
        <?php foreach ($tickets_risolti as $t): ?>
          <div class="ticket-admin">
            <div class="titolo"><?php echo htmlspecialchars($t['oggetto_domanda']); ?></div>
            <div class="data">Data: <?php echo htmlspecialchars($t['data_domanda']); ?></div>
            <div class="corpo"><?php echo nl2br(htmlspecialchars($t['domanda_txt'])); ?></div>
            <div class="risposta"><b>Risposta:</b> <?php echo nl2br(htmlspecialchars($t['risposta_txt'])); ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  <script>
    // Gestione invio risposta via AJAX
    document.querySelectorAll('.rispondi-form').forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = this.getAttribute('data-id');
        const risposta = this.querySelector('textarea').value;
        const msgSpan = this.querySelector('.msg');
        fetch('/marconnessi/pages/api/rispondiTicket.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id_ticket: id, risposta_txt: risposta })
        })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            msgSpan.innerHTML = "Risposta inviata!";
            // Prendi il div del ticket
            const ticketDiv = document.getElementById('ticket-' + id);
            // Prendi la risposta appena inviata
            const rispostaTesto = ticketDiv.querySelector('textarea').value;
            // Crea il nuovo HTML per la sezione completati
            const completatiSection = document.querySelector('.ticket-section:nth-of-type(2)');
            const nuovoTicket = document.createElement('div');
            nuovoTicket.className = 'ticket-admin';
            nuovoTicket.innerHTML = `
              <div class="titolo">${ticketDiv.querySelector('.titolo').innerHTML}</div>
              <div class="data">${ticketDiv.querySelector('.data').innerHTML}</div>
              <div class="corpo">${ticketDiv.querySelector('.corpo').innerHTML}</div>
              <div class="risposta"><b>Risposta:</b> ${rispostaTesto.replace(/\n/g, '<br>')}</div>
            `;
            completatiSection.appendChild(nuovoTicket);
            // Rimuovi il ticket dalla sezione in attesa
            ticketDiv.remove();
          } else {
            msgSpan.innerHTML = "Errore: " + (data.message || "Impossibile inviare.");
          }
        })
        .catch(() => {
          msgSpan.innerHTML = "Errore di rete.";
        });
      });
    });
  </script>
</body>
</html>