
<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["ruolo"] != 1) {
    header("Location: Login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Gestione Database</title>
  <link rel="stylesheet" href="../assets/style-home.css">
  <style>
    .crud-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .crud-table th, .crud-table td { border: 1px solid #ccc; padding: 8px; }
    .crud-table th { background: #f0f4f8; }
    .crud-form input { width: 100%; }
    .crud-form button { background: #1976d2; color: #fff; border: none; border-radius: 4px; padding: 6px 16px; cursor: pointer; }
    .crud-form button:hover { background: #005b99; }
  </style>
</head>
<body>
<div class="container">
  <h1>Gestione Database</h1>
  <select id="tabella-select">
    <option value="annunci">Annunci</option>
    <option value="persone">Persone</option>
    <!-- aggiungi altre tabelle -->
  </select>
  <div id="crud-content"></div>
</div>
<script>
function loadCRUD(tabella) {
  fetch(`/marconnessi/pages/api/crud/read${tabella.charAt(0).toUpperCase() + tabella.slice(1)}.php`)
    .then(r => r.json())
    .then(data => {
      // Costruisci la tabella e i form dinamicamente in JS
      // ... (puoi usare template string e cicli per generare la tabella)
    });
}
document.getElementById('tabella-select').addEventListener('change', function() {
  loadCRUD(this.value);
});
loadCRUD('annunci'); // default
</script>
</body>
</html>