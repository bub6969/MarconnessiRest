# MarconnessiRest
Istruzioni per l’uso
1. Installazione e configurazione
Copia del progetto:
Copia l’intera cartella del progetto nella directory htdocs/ di XAMPP (ad esempio C:\xampp\htdocs\MarconnessiRest).

Avvio dei servizi:
Avvia il server Apache e il database MySQL dal pannello di controllo di XAMPP.

Importazione del database:
Importa il file SQL fornito nel database MySQL tramite phpMyAdmin o un altro client MySQL.

Configurazione del database:
Apri il file config/database.php e verifica i parametri di connessione (host, username, password, dbname). Assicurati che corrispondano al tuo ambiente locale.

2. Accesso agli endpoint REST
Ogni endpoint è accessibile tramite URL locale.

Esempio per login utente:

bash
Copia
Modifica
http://localhost/MarconnessiRest/tabelle/user/loginUser.php
Alcuni endpoint utili:

Creazione annuncio: /tabelle/annuncio/createAnnuncio.php

Lettura risposte a un ticket: /tabelle/ticketRisposta/readRisposta.php

3. Test degli endpoint
Puoi testare le API con:

Postman o altri client HTTP,

cURL da terminale,

chiamate AJAX dal frontend.

4. Formato delle richieste e risposte
Le richieste POST devono inviare dati in formato JSON.

Le risposte degli endpoint sono sempre in formato JSON, con una struttura uniforme per facilitare l’integrazione.

5. Struttura del progetto
models/ – contiene la logica applicativa.

tabelle/ – script REST per ogni tabella o funzionalità.

config/ – configurazione della connessione al database.

Questa organizzazione modulare consente una facile manutenzione, scalabilità e riuso del codice.

File inclusi
Codice sorgente PHP

File di configurazione

Script SQL per il database

Questo file README.md
