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

document.addEventListener("DOMContentLoaded", function () {
  // --- Mostra la data di oggi ---
  const giorni = ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"];
  const mesi = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
  const oggi = new Date();
  const dataFormattata = `${giorni[oggi.getDay()]} ${oggi.getDate()} ${mesi[oggi.getMonth()]} ${oggi.getFullYear()}`;
  document.getElementById("data-oggi").innerText = dataFormattata;

  // --- Mostra nome utente ---
  fetch('/marconnessi/pages/profilo.php?json=1')
    .then(response => response.json())
    .then(data => {
      if (data.nome) {
        document.getElementById("benvenuto-utente").innerText = "Benvenuto " + data.nome;
      }
    });

  // --- Caricamento orario settimanale ---
  fetch("api/orario_settimanale.php")
    .then(response => {
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then(data => {
      const container = document.getElementById("orario-settimanale");
      if (!container) return;

      if (Object.keys(data).length === 0) {
        container.innerHTML = "<p>Nessuna lezione trovata.</p>";
        return;
      }

      let htmlContent = "";
      for (const giorno in data) {
        const lezioni = data[giorno];
        htmlContent += `<h3>${giorno}</h3><table class="blocco-table">
          <thead><tr><th>Ora</th><th>Materia</th><th>Aula</th><th>Professore</th></tr></thead><tbody>`;
        lezioni.forEach(lezione => {
          htmlContent += `<tr>
            <td>${lezione.ora}</td>
            <td>${lezione.materia}</td>
            <td>${lezione.aula}</td>
            <td>${lezione.professore}</td>
          </tr>`;
        });
        htmlContent += "</tbody></table>";
      }
      container.innerHTML = htmlContent;
    })
    .catch(error => {
      console.error("Errore nel caricamento dell'orario:", error);
      const container = document.getElementById("orario-settimanale");
      if (container) container.innerHTML = "<p>Errore nel caricamento dell'orario.</p>";
    });

  // --- Sidebar profilo ---
  document.getElementById("open-profilo").onclick = function() {
    document.getElementById("profiloSidebar").style.width = "350px";
    fetch('/marconnessi/pages/profilo.php?json=1')
      .then(response => response.json())
      .then(data => {
        document.getElementById("profilo-content").innerHTML = `
          <div class="profile-info"><span class="profile-label">Nome:</span> ${data.nome}</div>
          <div class="profile-info"><span class="profile-label">Cognome:</span> ${data.cognome}</div>
          <div class="profile-info"><span class="profile-label">Email:</span><br>
            <span class="profile-value mail-scroll">${data.mail}</span>
          </div>
          <div class="profile-info"><span class="profile-label">Data di nascita:</span> ${data.data_nascita}</div>
          <div class="profile-info"><span class="profile-label">Ruolo:</span> ${data.ruolo}</div>
          <a href="../logout.php" class="logout-btn">Logout</a>
          <a href="api/cambia-password.php" class="logout-btn" style="background:#1976d2;margin-top:10px;">Cambia password</a>
        `;
      });
  };
  document.getElementById("close-profilo").onclick = () => document.getElementById("profiloSidebar").style.width = "0";

  // --- Sidebar mappa ---
  document.getElementById("open-mappa").onclick = e => {
    e.preventDefault();
    document.getElementById("mappaPopup").style.display = "flex";
  };
  document.getElementById("close-mappa").onclick = () => document.getElementById("mappaPopup").style.display = "none";

  // --- Toggle menu gestione ---
  const gestioneToggle = document.getElementById('gestione-toggle');
  const gestioneMenu = document.querySelector('.gestione-menu');
  if (gestioneToggle && gestioneMenu) {
    gestioneToggle.addEventListener('click', e => {
      e.preventDefault();
      gestioneMenu.classList.toggle('open');
    });
    document.addEventListener('click', e => {
      if (!gestioneMenu.contains(e.target) && !gestioneToggle.contains(e.target)) {
        gestioneMenu.classList.remove('open');
      }
    });
  }

  // --- Bacheca annunci ---
  function loadBachecaAnnunci() {
    fetch('../tabelle/annuncio/readAnnuncio.php')
      .then(response => {
        if (!response.ok) throw new Error('Errore HTTP: ' + response.status);
        return response.json();
      })
      .then(data => {
        const lista = document.getElementById('bacheca-content');
        if (!lista) return;
        lista.innerHTML = '';

        if (data.records && data.records.length > 0) {
          data.records.forEach(annuncio => {
            const li = document.createElement('li');
            const dataAnnuncio = new Date(annuncio.data_annuncio).toLocaleString('it-IT', {
              day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
            const autore = (annuncio.nome && annuncio.cognome) ? `${annuncio.nome} ${annuncio.cognome}` : 'Autore sconosciuto';

            li.innerHTML = `
              <strong>${annuncio.oggetto_annuncio || 'Nessun oggetto'}</strong>
              <p>${annuncio.corpo_annuncio || 'Nessun testo'}</p>
              <small>Pubblicato il: ${dataAnnuncio}</small>
              <small>Da: ${autore}</small>`;
            lista.appendChild(li);
          });
        } else {
          lista.innerHTML = `<li>${data.message || 'Nessun annuncio presente'}</li>`;
        }
      })
      .catch(error => {
        console.error('Errore bacheca:', error);
        const lista = document.getElementById('bacheca-content');
        if (lista) lista.innerHTML = '<li>Errore nel caricamento degli annunci.</li>';
      });
  }

  const openBacheca = document.getElementById("open-bacheca");
  if (openBacheca) {
    openBacheca.onclick = function(e) {
      e.preventDefault();
      document.getElementById("bachecaSidebar").style.width = "400px";
      loadBachecaAnnunci();
    };
  }

  const closeBacheca = document.getElementById("close-bacheca");
  if (closeBacheca) {
    closeBacheca.onclick = () => document.getElementById("bachecaSidebar").style.width = "0";
  }

  const formAnnuncio = document.getElementById("form-annuncio-sidebar");
  if (formAnnuncio) {
    formAnnuncio.addEventListener("submit", function(e) {
      e.preventDefault();
      const oggetto = document.getElementById("oggetto_annuncio_sidebar");
      const corpo = document.getElementById("corpo_annuncio_sidebar");
      const msg = document.getElementById("msg-annuncio-sidebar");

      fetch('../tabelle/annuncio/createAnnuncio.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ oggetto_annuncio: oggetto.value, corpo_annuncio: corpo.value })
      })
      .then(response => response.json())
      .then(data => {
        msg.textContent = data.message || "Risposta inattesa.";
        if (data.message && data.message.toLowerCase().includes("correttamente")) {
          formAnnuncio.reset();
          loadBachecaAnnunci();
        }
      })
      .catch(error => {
        console.error('Errore invio annuncio:', error);
        msg.textContent = "Errore durante l'invio dell'annuncio.";
      });
    });
  }
});
