jQuery(function($) {
  $('div[data-href]').addClass('clickable').click(function() {
    window.location = $(this).attr('data-href');
  }).find('a').hover(function() {
    $(this).parents('div').unbind('click');
  }, function() {
    $(this).parents('div').click(function() {
      window.location = $(this).attr('data-href');
    });
  });
});

document.addEventListener("DOMContentLoaded", function() {
  // --- TUTTO IL TUO CODICE CHE ACCEDE AL DOM QUI DENTRO ---

  // Data di oggi formattata
  const giorni = ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"];
  const mesi = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
  const oggi = new Date();
  const giornoSettimana = giorni[oggi.getDay()];
  const giorno = oggi.getDate();
  const mese = mesi[oggi.getMonth()];
  const anno = oggi.getFullYear();
  const dataFormattata = `${giornoSettimana} ${giorno} ${mese} ${anno}`;
  document.getElementById("data-oggi").innerText = dataFormattata;

  /* // BLOCCO PROBLEMATICO COMMENTATO COME DISCUSSO IN PRECEDENZA
    // Questo blocco tentava di caricare dati da 'readAnnuncio.php' e inserirli in 'lezioni-row',
    // il che causava errori poiché 'lezioni-row' non era definito in quel contesto
    // e l'iterazione sui dati non era corretta per la struttura restituita da readAnnuncio.php.
    // La logica corretta per la bacheca è gestita dalla funzione loadBachecaAnnunci().

    // Caricamento dati orario 
    fetch('http://localhost/MARCONNESSI/tabelle/annuncio/readAnnuncio.php')
      .then(response => {
        if (!response.ok) {
          throw new Error("Errore nella risposta");
        }
        return response.json();
      })
      .then(data => {
        const row = document.getElementById('lezioni-row'); // 'lezioni-row' probabilmente non esiste o non è pertinente qui
        if (row) { // Aggiunto controllo per evitare errori se 'lezioni-row' non esiste
            row.innerHTML = '';
            // La struttura di 'data' da readAnnuncio.php è { records: [...] }
            // Quindi data.forEach non funzionerebbe direttamente. Sarebbe data.records.forEach.
            // Inoltre, 'utente' è un nome fuorviante qui; sarebbero 'annunci'.
            data.forEach(utente => { 
              const cell = document.createElement('td');
              cell.innerHTML = `
                <strong>${utente.nome}</strong><br>
                ${utente.cognome}
              `;
              row.appendChild(cell);
            });
        } else {
            console.warn("Elemento con ID 'lezioni-row' non trovato. Impossibile caricare i dati orario inesistenti.");
        }
      })
      .catch(error => {
        console.error('Errore nel recupero dati (blocco orario problematico):', error);
      });
  */
 
  // Apertura e chiusura sidebar profilo
  document.getElementById("open-profilo").onclick = function() {
    document.getElementById("profiloSidebar").style.width = "350px";
    // Carica i dati del profilo via AJAX
    fetch('/marconnessi/pages/profilo.php?json=1')
      .then(response => response.json())
      .then(data => {
        document.getElementById("profilo-content").innerHTML = `
          <div class="profile-info"><span class="profile-label">Nome:</span> ${data.nome}</div>
          <div class="profile-info"><span class="profile-label">Cognome:</span> ${data.cognome}</div>
          <div class="profile-info">
            <span class="profile-label">Email:</span><br>
            <span class="profile-value mail-scroll">${data.mail}</span>
          </div>
          <div class="profile-info"><span class="profile-label">Data di nascita:</span> ${data.data_nascita}</div>
          <div class="profile-info"><span class="profile-label">Ruolo:</span> ${data.ruolo}</div>
          <a href="../logout.php" class="logout-btn">Logout</a>
          <a href="api/cambia-password.php" class="logout-btn" style="background:#1976d2;margin-top:10px;">Cambia password</a>
        `;
      })
      .catch(error => console.error('Errore nel caricamento del profilo:', error)); // Aggiunto catch per il fetch del profilo
  };
  document.getElementById("close-profilo").onclick = function() {
    document.getElementById("profiloSidebar").style.width = "0";
  };

  // --- BLOCCO MAPPA ---
  document.getElementById("open-mappa").addEventListener("click", function(e) {
    e.preventDefault();
    document.getElementById("mappaPopup").style.display = "flex";
  });
  document.getElementById("close-mappa").addEventListener("click", function() {
    document.getElementById("mappaPopup").style.display = "none";
  });

  // Mostra il nome utente nel titolo di benvenuto
  fetch('/marconnessi/pages/profilo.php?json=1')
    .then(response => response.json())
    .then(data => {
      if (data.nome) {
        document.getElementById("benvenuto-utente").innerText = "Benvenuto " + data.nome;
      }
    })
    .catch(error => console.error('Errore nel caricamento del nome utente:', error)); // Aggiunto catch

}); // Fine del primo DOMContentLoaded listener

document.addEventListener('DOMContentLoaded', function() { // Secondo DOMContentLoaded: può essere unito al primo
  var gestioneToggle = document.getElementById('gestione-toggle');
  var gestioneMenu = document.querySelector('.gestione-menu');
  if (gestioneToggle && gestioneMenu) {
    gestioneToggle.addEventListener('click', function(e) {
      e.preventDefault();
      gestioneMenu.classList.toggle('open');
    });
    // Chiude il dropdown cliccando fuori
    document.addEventListener('click', function(e) {
      if (gestioneMenu && !gestioneMenu.contains(e.target) && !gestioneToggle.contains(e.target)) { // Aggiunto controllo per non chiudere se si clicca sul toggle
        gestioneMenu.classList.remove('open');
      }
    });
  }
});

// NOTA: Il seguente blocco DOMContentLoaded è ridondante con quello sopra per la gestione del toggle.
// Puoi scegliere uno dei due meccanismi o unificarli. Ho lasciato questo per coerenza con il file originale, ma si sovrappone.
/* document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('gestione-toggle');
  const submenu = document.getElementById('submenu-gestione'); // Presumo sia '.submenu-gestione' come classe

  if (toggle && submenu) { // Aggiunto controllo null
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      if (submenu.style.maxHeight && submenu.style.maxHeight !== '0px') {
        submenu.style.maxHeight = '0px';
      } else {
        // Assicurati che submenu sia l'elemento corretto (ul.submenu-gestione)
        submenu.style.maxHeight = submenu.scrollHeight + 'px'; 
      }
    });
  }
});
*/


document.addEventListener("DOMContentLoaded", function () { // Terzo DOMContentLoaded: può essere unito al primo
  fetch("api/orario_settimanale.php") // Assicurati che questo endpoint esista e sia corretto
    .then(response => {
        if (!response.ok) { // Controllo della risposta
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
      const container = document.getElementById("orario-settimanale");
      if (!container) { // Controllo se il container esiste
          console.warn("Elemento 'orario-settimanale' non trovato.");
          return;
      }
      if (Object.keys(data).length === 0) {
        container.innerHTML = "<p>Nessuna lezione trovata.</p>";
        return;
      }

      let htmlContent = ""; // Costruisci l'HTML in una stringa per efficienza
      for (const giorno in data) {
        const lezioni = data[giorno];
        htmlContent += `<h3>${giorno}</h3><table class="blocco-table"><thead><tr><th>Ora</th><th>Materia</th><th>Aula</th></tr></thead><tbody>`;
        lezioni.forEach(lezione => {
          htmlContent += `<tr>
            <td>${lezione.ora}</td>
            <td>${lezione.materia}</td>
            <td>${lezione.aula}</td>
          </tr>`;
        });
        htmlContent += "</tbody></table>";
      }
      container.innerHTML = htmlContent; // Singolo aggiornamento del DOM
    })
    .catch(error => {
      console.error("Errore nel caricamento dell'orario settimanale:", error);
      const container = document.getElementById("orario-settimanale");
      if (container) { // Mostra errore nel container se esiste
          container.innerHTML = "<p>Errore nel caricamento dell'orario.</p>";
      }
    });

  // Mostra la data di oggi (Questa parte è già presente nel primo DOMContentLoaded, potrebbe essere ridondante qui)
  // Se vuoi aggiornare solo #data-oggi in questo blocco, va bene, altrimenti rimuovi se già gestito.
  /*
  const giorniSettimana = ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"];
  const oggiData = new Date(); // rinominato per evitare conflitto con 'oggi' globale nel primo listener
  const dataOggiEl = document.getElementById("data-oggi");
  if (dataOggiEl && dataOggiEl.textContent.includes(giorniSettimana[oggiData.getDay()])) {
      // Già impostato dal primo listener, non serve rifarlo a meno di logica specifica.
  } else if (dataOggiEl) {
      // Questa parte per impostare solo il giorno della settimana sembra incompleta rispetto al primo listener
      // dataOggiEl.textContent = giorniSettimana[oggiData.getDay()];
  }
  */
});

// --- LOGICA BACHECA ANNUNCI ---
// Questa funzione carica e visualizza gli annunci nella bacheca.
function loadBachecaAnnunci() {
    fetch('../tabelle/annuncio/readAnnuncio.php') // Path corretto come da file fornito
        .then(response => {
            if (!response.ok) {
                throw new Error('Errore HTTP: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            const lista = document.getElementById('bacheca-content');
            if (!lista) {
                console.error("Elemento 'bacheca-content' non trovato!");
                return;
            }
            lista.innerHTML = ''; // Pulisce la lista precedente
            
            if (data.records && data.records.length > 0) {
                data.records.forEach(annuncio => {
                    const li = document.createElement('li');
                    // Formattazione della data migliorata e gestione di nome/cognome
                    const dataAnnuncio = new Date(annuncio.data_annuncio).toLocaleString('it-IT', {
                        day: '2-digit', month: '2-digit', year: 'numeric',
                        hour: '2-digit', minute: '2-digit'
                    });
                    const autore = (annuncio.nome && annuncio.cognome) ? `${annuncio.nome} ${annuncio.cognome}` : 'Autore sconosciuto';

                    li.innerHTML = `
                        <strong>${annuncio.oggetto_annuncio || 'Nessun oggetto'}</strong>
                        <p>${annuncio.corpo_annuncio || 'Nessun testo'}</p>
                        <small>Pubblicato il: ${dataAnnuncio}</small>
                        <small>Da: ${autore}</small>
                    `;
                    lista.appendChild(li);
                });
            } else {
                // Se data.message esiste (es. "Nessun annuncio trovato."), mostralo, altrimenti un messaggio di default.
                lista.innerHTML = `<li>${data.message || 'Nessun annuncio presente'}</li>`;
            }
        })
        .catch(error => {
            console.error('Errore nel caricamento degli annunci della bacheca:', error);
            const lista = document.getElementById('bacheca-content');
            if (lista) {
                lista.innerHTML = 
                    '<li>Errore nel caricamento degli annunci. Controlla la console per i dettagli.</li>';
            }
        });
}

// Event listener per aprire la bacheca
const openBachecaButton = document.getElementById("open-bacheca");
if (openBachecaButton) {
    openBachecaButton.addEventListener("click", function(e) {
        e.preventDefault();
        const bachecaSidebar = document.getElementById("bachecaSidebar");
        if (bachecaSidebar) {
            bachecaSidebar.style.width = "400px"; // o la larghezza desiderata
        }
        loadBachecaAnnunci(); // Carica gli annunci quando la bacheca viene aperta
    });
}

// Event listener per chiudere la bacheca
const closeBachecaButton = document.getElementById("close-bacheca");
if (closeBachecaButton) {
    closeBachecaButton.addEventListener("click", function() {
        const bachecaSidebar = document.getElementById("bachecaSidebar");
        if (bachecaSidebar) {
            bachecaSidebar.style.width = "0";
        }
    });
}

// Event listener per il form di aggiunta annuncio (solo per admin)
const formAnnuncio = document.getElementById("form-annuncio-sidebar");
if (formAnnuncio) { // Questo assicura che il codice venga eseguito solo se il form esiste (es. per l'admin)
    formAnnuncio.addEventListener("submit", function(e) {
        e.preventDefault(); // Impedisce l'invio tradizionale del form
        
        const oggettoAnnuncioInput = document.getElementById("oggetto_annuncio_sidebar");
        const corpoAnnuncioInput = document.getElementById("corpo_annuncio_sidebar");
        const msgAnnuncioDiv = document.getElementById("msg-annuncio-sidebar");

        if (!oggettoAnnuncioInput || !corpoAnnuncioInput || !msgAnnuncioDiv) {
            console.error("Elementi del form annuncio non trovati.");
            return;
        }

        const formData = {
            oggetto_annuncio: oggettoAnnuncioInput.value,
            corpo_annuncio: corpoAnnuncioInput.value
        };
        
        fetch('../tabelle/annuncio/createAnnuncio.php', { // Path corretto come da file fornito
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Potrebbe essere necessario aggiungere altri header qui, es. per l'autorizzazione se implementata
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            // createAnnuncio.php restituisce Content-Type: application/json; charset=UTF-8
            // quindi response.json() è appropriato.
            // Controlliamo lo status per gestire meglio errori HTTP che restituiscono comunque JSON
            if (!response.ok && response.status !== 400 && response.status !== 503 && response.status !== 201) { 
                // 201 è successo, 400 e 503 sono errori gestiti da createAnnuncio con JSON
                throw new Error(`Errore HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.message) {
                msgAnnuncioDiv.textContent = data.message;
                // Se l'annuncio è stato creato correttamente (controlla il messaggio o lo status code della risposta originale)
                // Il file PHP restituisce 201 per successo.
                // Potremmo voler controllare lo status code originale qui se disponibile,
                // oppure basarci sul messaggio. Il file PHP dice: "Annuncio creato correttamente."
                if (data.message.toLowerCase().includes("correttamente")) {
                    formAnnuncio.reset(); // Pulisce il form
                    loadBachecaAnnunci(); // Ricarica la lista degli annunci
                }
            } else {
                msgAnnuncioDiv.textContent = "Risposta non prevista dal server.";
            }
        })
        .catch(error => {
            console.error('Errore durante la creazione dell\'annuncio:', error);
            msgAnnuncioDiv.textContent = "Errore durante l'invio dell'annuncio. Controlla la console.";
        });
    });
}

// Nota: È buona pratica unificare i listener DOMContentLoaded se possibile, 
// per evitare codice sparso e potenziali conflitti o ridondanze.
// Ho mantenuto la struttura del file originale ma aggiunto controlli di nullità e gestione degli errori.