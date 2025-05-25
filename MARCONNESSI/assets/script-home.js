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
    data.forEach(annuncio => {
      const li = document.createElement('li');
      li.innerHTML = `<strong>${annuncio.titolo}</strong>: ${annuncio.testo}`;
      lista.appendChild(li);
    });
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
      console.log('Risposta annunci:', data); // <--- AGGIUNGI QUESTA RIGA
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