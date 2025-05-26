<?php
<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["ruolo"] != 3) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Crea Nuovo Ticket</title>
  <link rel="stylesheet" href="../assets/style-home.css">
  <style>
    .ticket-form {
       max-width: 600px;
       margin: 40px auto;
       padding: 20px;
       border-radius: 8px;
       box-shadow: 0 2px 8px rgba(0,0,0,0.1);
       background: #fff;
    }
    .ticket-form label {
       display: block;
       margin-bottom: 8px;
       font-weight: bold;
    }
    .ticket-form input,
    .ticket-form textarea {
       width: 100%;
       margin: 10px 0;
       padding: 10px;
       border: 1px solid #ddd;
       border-radius: 4px;
    }
    .ticket-form button {
       padding: 10px 20px;
       background: #1976d2;
       color: #fff;
       border: none;
       border-radius: 4px;
       cursor: pointer;
    }
    .ticket-form button:hover {
       background: #005b99;
    }
    #message {
       margin-top: 20px;
       font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">MARCONNESSI</div>
    <nav>
      <ul>
         <li><a href="Home.php">Home</a></li>
         <li><a href="i-miei-ticket.html">I miei ticket</a></li>
         <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <div class="container">
    <h1>Crea Nuovo Ticket</h1>
    <div class="ticket-form">
       <form id="ticketForm">
         <label for="oggetto">Oggetto Domanda:</label>
         <input type="text" id="oggetto" name="oggetto" required>
         
         <label for="domanda_txt">Descrizione:</label>
         <textarea id="domanda_txt" name="domanda_txt" rows="5" required></textarea>
         
         <button type="submit">Invia Ticket</button>
       </form>
       <div id="message"></div>
    </div>
  </div>
  <script>
    document.getElementById("ticketForm").addEventListener("submit", function(e) {
      e.preventDefault();
      let oggetto = document.getElementById("oggetto").value;
      let domanda = document.getElementById("domanda_txt").value;
      
      fetch("../tabelle/ticket/createTicket.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ oggetto: oggetto, corpo: domanda })
      })
      .then(response => response.json())
      .then(data => {
        document.getElementById("message").innerText = data.message;
        if(response.status === 201){
           // eventualmente reindirizza o ripulisci il form
           document.getElementById("ticketForm").reset();
        }
      })
      .catch(error => {
        document.getElementById("message").innerText = "Errore nella creazione del ticket.";
        console.error("Errore:", error);
      });
    });
  </script>
</body>
</html>