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

  // Caricamento dati orario
  fetch('http://localhost/MARCONNESSI/tabelle/annuncio/readAnnuncio.php')
    .then(response => {
      if (!response.ok) {
        throw new Error("Errore nella risposta");
      }
      return response.json();
    })
    .then(data => {
      const row = document.getElementById('lezioni-row');
      row.innerHTML = '';
      data.forEach(utente => {
        const cell = document.createElement('td');
        cell.innerHTML = `
          <strong>${utente.nome}</strong><br>
          ${utente.cognome}
        `;
        row.appendChild(cell);
      });
    })
    .catch(error => {
      console.error('Errore nel recupero dati:', error);
    });

  // Caricamento annunci in bacheca
  fetch('/marconnessi/tabelle/annuncio/readAnnuncio.php')
    .then(response => response.json())
    .then(data => {
      const lista = document.getElementById('lista-annunci');
      lista.innerHTML = '';
      if (data.records && data.records.length > 0) {
        data.records.forEach(annuncio => {
          const li = document.createElement('li');
          li.innerHTML = `<strong>${annuncio.oggetto_annuncio}</strong><br>
                          <span>${annuncio.corpo_annuncio}</span><br>
                          <small>${annuncio.data_annuncio}</small>`;
          lista.appendChild(li);
        });
      } else {
        lista.innerHTML = '<li>Nessun annuncio presente.</li>';
      }
    })
    .catch(error => {
      document.getElementById('lista-annunci').innerHTML = '<li>Errore nel caricamento degli annunci.</li>';
    });

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
      });
  };
  document.getElementById("close-profilo").onclick = function() {
    document.getElementById("profiloSidebar").style.width = "0";
  };

  // Apertura e chiusura sidebar bacheca
  document.getElementById("open-bacheca").onclick = function() {
    document.getElementById("bachecaSidebar").style.width = "350px";
    // Carica gli annunci nella sidebar
    fetch('/marconnessi/tabelle/annuncio/readAnnuncio.php')
      .then(response => response.json())
      .then(data => {
        const lista = document.getElementById('bacheca-content');
        lista.innerHTML = '';
        if (data.records && data.records.length > 0) {
          data.records.forEach(annuncio => {
            const li = document.createElement('li');
            li.innerHTML = `<strong>${annuncio.titolo}</strong>: ${annuncio.testo}`;
            lista.appendChild(li);
          });
        } else {
          lista.innerHTML = '<li>Nessun annuncio presente.</li>';
        }
      })
      .catch(error => {
        document.getElementById('bacheca-content').innerHTML = '<li>Errore nel caricamento degli annunci.</li>';
      });
  };
  document.getElementById("close-bacheca").onclick = function() {
    document.getElementById("bachecaSidebar").style.width = "0";
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
    });
});

document.addEventListener('DOMContentLoaded', function() {
  var gestioneToggle = document.getElementById('gestione-toggle');
  var gestioneMenu = document.querySelector('.gestione-menu');
  if (gestioneToggle && gestioneMenu) {
    gestioneToggle.addEventListener('click', function(e) {
      e.preventDefault();
      gestioneMenu.classList.toggle('open');
    });
    // Chiude il dropdown cliccando fuori
    document.addEventListener('click', function(e) {
      if (!gestioneMenu.contains(e.target)) {
        gestioneMenu.classList.remove('open');
      }
    });
  }
});


document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.getElementById('gestione-toggle');
  const submenu = document.getElementById('submenu-gestione');

  toggle.addEventListener('click', function (e) {
    e.preventDefault();
    if (submenu.style.maxHeight && submenu.style.maxHeight !== '0px') {
      submenu.style.maxHeight = '0px';
    } else {
      submenu.style.maxHeight = submenu.scrollHeight + 'px';
    }
  });
});

document.addEventListener("DOMContentLoaded", function() {
  // Apri la sidebar Bacheca
  const openBacheca = document.getElementById("open-bacheca");
  if (openBacheca) {
    openBacheca.addEventListener("click", function(e) {
      e.preventDefault();
      document.getElementById("bachecaSidebar").style.width = "400px";
      loadBachecaAnnunci();
    });
  }

  // Chiudi la sidebar Bacheca
  const closeBacheca = document.getElementById("close-bacheca");
  if (closeBacheca) {
    closeBacheca.addEventListener("click", function() {
      document.getElementById("bachecaSidebar").style.width = "0";
    });
  }

  // Carica gli annunci nella sidebar
  function loadBachecaAnnunci() {
    fetch("/marconnessi/tabelle/annuncio/readAnnuncio.php")
      .then(r => r.text())
      .then(txt => { console.log(txt); return JSON.parse(txt); })
      .then(data => {
        const ul = document.getElementById("bacheca-content");
        ul.innerHTML = "";
        if (data.records && data.records.length > 0) {
          data.records.forEach(annuncio => {
            const li = document.createElement("li");
            li.innerHTML = `<strong>${annuncio.oggetto_annuncio}</strong><br>
                            <span>${annuncio.corpo_annuncio}</span><br>
                            <small>${annuncio.data_annuncio}</small>`;
            ul.appendChild(li);
          });
        } else {
          ul.innerHTML = "<li>Nessun annuncio presente.</li>";
        }
      })
      .catch(error => {
        console.error("Errore nel recupero dati:", error);
        document.getElementById("bacheca-content").innerHTML = "<li>Errore nel caricamento degli annunci.</li>";
      });
  }

  // Solo per admin: gestione form annuncio nella sidebar
  const formAnnuncioSidebar = document.getElementById("form-annuncio-sidebar");
  if (formAnnuncioSidebar) {
    formAnnuncioSidebar.addEventListener("submit", function(e) {
      e.preventDefault();
      const oggetto = document.getElementById("oggetto_annuncio_sidebar").value;
      const corpo = document.getElementById("corpo_annuncio_sidebar").value;
      fetch("/marconnessi/tabelle/annuncio/createAnnuncio.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          oggetto_annuncio: document.getElementById("oggetto_annuncio_sidebar").value,
          corpo_annuncio: document.getElementById("corpo_annuncio_sidebar").value
        })
      })
      .then(r => r.json())
      .then(data => {
        const msg = document.getElementById("msg-annuncio-sidebar");
        if (data.message && data.message.indexOf("creato correttamente") !== -1) {
          msg.innerHTML = "Annuncio aggiunto!";
          formAnnuncioSidebar.reset();
          loadBachecaAnnunci();
        } else {
          msg.innerHTML = "Errore: " + (data.message || "Impossibile aggiungere.");
        }
      })
      .catch(() => {
        document.getElementById("msg-annuncio-sidebar").innerHTML = "Errore di rete.";
      });
    });
  }

  const lista = document.getElementById("bacheca-content");
  if (lista) {
    lista.innerHTML = "...";
  }
});



document.addEventListener("DOMContentLoaded", function () {
  fetch("api/orario_settimanale.php")
    .then(response => response.json())
    .then(data => {
      const container = document.getElementById("orario-settimanale");
      if (Object.keys(data).length === 0) {
        container.innerHTML = "<p>Nessuna lezione trovata.</p>";
        return;
      }

      for (const giorno in data) {
        const lezioni = data[giorno];
        let html = `<h3>${giorno}</h3><table class="blocco-table"><thead><tr><th>Ora</th><th>Materia</th><th>Aula</th></tr></thead><tbody>`;
        lezioni.forEach(lezione => {
          html += `<tr>
            <td>${lezione.ora}</td>
            <td>${lezione.materia}</td>
            <td>${lezione.aula}</td>
          </tr>`;
        });
        html += "</tbody></table>";
        container.innerHTML += html;
      }
    })
    .catch(error => {
      console.error("Errore nel caricamento dell'orario:", error);
    });

  // Mostra la data di oggi
  const giorniSettimana = ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"];
  const oggi = new Date();
  document.getElementById("data-oggi").textContent = giorniSettimana[oggi.getDay()];
});

