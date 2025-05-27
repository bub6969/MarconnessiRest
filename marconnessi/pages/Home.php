<?php
session_start();

// Check if the user is logged in AND if the 'ruolo' session variable is set.
// If either condition is false, redirect to the login page.
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["ruolo"])) {
    header("Location: Login/login.php");
    exit; // Always exit after a header redirect
}

$ruolo = $_SESSION["ruolo"]; // Now, this line should be safe.
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>HOME MARCONNESSI</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style-home.css">
</head>
<body>
<header>
    <div class="logo">MARCONNESSI</div>
    <nav>
        <ul>
            <li><a href="Home.php">Home</a></li>
            <?php if ($ruolo == 3): // Studente ?>
                <li><a href="#" id="open-bacheca">Bacheca</a></li>
                <li><a href="#" id="open-mappa">Mappa</a></li>
                <li><a href="i-miei-ticket.php">I miei ticket</a></li>
                <li><a href="#" id="open-profilo">Profilo</a></li>
            <?php elseif ($ruolo == 2): // Professore ?>
                <li><a href="#" id="open-orario-prof">Il mio orario</a></li>
                <li><a href="#" id="open-bacheca">Bacheca</a></li>
                <li><a href="#" id="open-mappa">Mappa</a></li>
                <li><a href="#" id="open-profilo">Profilo</a></li>
            <?php elseif ($ruolo == 1): // Amministratore ?>
                <li><a href="#" id="open-bacheca">Bacheca</a></li>
                <li><a href="#" id="open-mappa">Mappa</a></li>
                <li class="gestione-menu">
                    <a href="#" id="gestione-toggle">Gestione ▾</a>
                    <ul class="submenu-gestione">
                        <li><a href="ticket-admin.php">Gestione Ticket</a></li>
                        <li><a href="admin-utenti.php">Gestione Utenti</a></li>
                    </ul>
                </li>
                <li><a href="#" id="open-profilo">Profilo</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="container">
    <h1 class="titolo-pagina" id="benvenuto-utente">Benvenuto</h1>
    <p class="sottotitolo">Oggi è <span id="data-oggi"></span></p>

    <?php if ($ruolo != 1): ?>
    <div class="blocco">
        <h2>Orario Settimanale</h2>
        <div id="orario-settimanale">
            </div>
    </div>
    <?php endif; ?>

<div id="profiloSidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" id="close-profilo">×</a>
    <h2>Profilo Utente</h2>
    <div id="profilo-content">
        </div>
</div>

<div id="bachecaSidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" id="close-bacheca">×</a>
    <h2>Bacheca Annunci</h2>
    <?php if ($ruolo == 1): ?>
        <form id="form-annuncio-sidebar" style="margin: 16px 24px 24px 24px;">
            <input type="text" id="oggetto_annuncio_sidebar" placeholder="Oggetto" required style="width:100%;margin-bottom:8px;">
            <textarea id="corpo_annuncio_sidebar" placeholder="Testo" rows="3" required style="width:100%;margin-bottom:8px;"></textarea>
            <button type="submit" style="width:100%;">Aggiungi Annuncio</button>
            <div id="msg-annuncio-sidebar" style="margin-top:8px;font-size:15px;"></div>
        </form>
    <?php endif; ?>
    <ul id="bacheca-content"></ul>
</div>

<div id="mappaPopup" class="popup-mappa" style="display:none;">
    <a href="javascript:void(0)" class="closebtn" id="close-mappa">×</a>
    <div style="display: flex; flex-direction: column; align-items: center;">
        <img src="../assets/global_map.png" alt="Mappa Interattiva" style="max-width:90vw; max-height:80vh; border-radius:12px; box-shadow:0 0 20px #000;">
        <a href="https://www.google.com/maps/dir/?api=1&destination=43.67053992916821,10.639171733619332" target="_blank" style="margin-top:20px; padding:12px 28px; background:#1976d2; color:#fff; border-radius:8px; text-decoration:none; font-size:1.1em; font-weight:bold; box-shadow:0 2px 8px #0002;">
            Indicazioni stradali
        </a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script src="../assets/script-home.js"></script>
</body>
</html>