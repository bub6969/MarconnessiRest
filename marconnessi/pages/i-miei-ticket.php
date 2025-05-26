<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] != 3) {
    header("Location: Login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>I miei Ticket</title>
  <link rel="stylesheet" href="../assets/style-home.css">
  
</head>
<body>
  <header>
    <div class="logo">MARCONNESSI</div>
    <nav>
      <ul>
         <li><a href="Home.php">Home</a></li>
         <li><a href="i-miei-ticket.php">I miei ticket</a></li>
         <li><a href="../logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <h1>I miei Ticket</h1>
    <!-- Form per creare un nuovo ticket -->
    <div class="ticket-form">
      <form id="ticketForm">
         <label for="oggetto">Oggetto Domanda:</label>
         <input type="text" id="oggetto" name="oggetto" required>
         
         <label for="domanda_txt">Descrizione:</label>
         <textarea id="domanda_txt" name="domanda_txt" rows="5" required></textarea>
         
         <button type="submit">Invia Ticket</button>
      </form>
      <div id="formMessage"></div>
    </div>

    <!-- Lista ticket -->
    <div class="ticket-list" id="ticket-list">
      <!-- I ticket verranno inseriti qui tramite JavaScript -->
    </div>
  </div>

  <script>
    // Funzione per caricare i ticket dell'utente
    function loadTickets() {
      fetch("/marconnessi/pages/api/ticket_utente.php")
      .then(response => {
         if (!response.ok) {
            throw new Error("HTTP error: " + response.status);
         }
         return response.json();
      })
      .then(data => {
         console.log("Data ricevuta:", data);
         const list = document.getElementById("ticket-list");
         list.innerHTML = "";
         if (data.records && data.records.length > 0) {
            data.records.forEach(ticket => {
               // Imposta lo stato in base al contenuto di risposta (vuoto = "In attesa")
               const stato = ticket.risposta_txt ? "Risolto" : "In attesa";
               const ticketDiv = document.createElement("div");
               ticketDiv.className = "ticket " + (stato === "Risolto" ? "risolto" : "non-risolto");
               ticketDiv.innerHTML = `
                 <div class="titolo">${ticket.oggetto_domanda}</div>
                 <div class="data">Data: ${ticket.data_domanda}</div>
                 <div class="corpo">${ticket.domanda_txt}</div>
                 <div class="stato">Stato: ${stato}</div>
                 ${stato === "Risolto" ? `<div class="risposta"><b>Risposta:</b> ${ticket.risposta_txt}</div>` : ""}
               `;
               list.appendChild(ticketDiv);
            });
         } else {
            list.innerHTML = "<p>Nessun ticket trovato.</p>";
         }
      })
      .catch(error => {
         console.error("Errore nel caricamento dei ticket:", error);
         document.getElementById("ticket-list").innerHTML = "<p>Errore nel caricamento dei ticket.</p>";
      });
    }

    // Gestione dell'invio del form per creare un nuovo ticket
    document.getElementById("ticketForm").addEventListener("submit", function(event) {
      event.preventDefault();
      const data = {
        oggetto_domanda: document.getElementById("oggetto").value,
        domanda_txt: document.getElementById("domanda_txt").value,
      };
      fetch("/marconnessi/pages/api/createTicket.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      })
      .then(response => {
         if (!response.ok) {
            throw new Error("HTTP error: " + response.status);
         }
         return response.json();
      })
      .then(result => {
         console.log("Risposta dal server:", result);
         // Verifica il messaggio in base al contenuto restituito
         if (result.message && result.message.indexOf("creato correttamente") !== -1) {
            document.getElementById("formMessage").innerHTML = "<p>Ticket inviato con successo!</p>";
            document.getElementById("ticketForm").reset();
            loadTickets();
         } else {
            document.getElementById("formMessage").innerHTML = "<p>Errore nell'invio del ticket.</p>";
         }
      })
      .catch(error => {
         console.error("Errore nella richiesta:", error);
         document.getElementById("formMessage").innerHTML = "<p>Errore nella richiesta.</p>";
      });
    });

    // Carica i ticket al caricamento della pagina
    loadTickets();
  </script>
</body>
</html>