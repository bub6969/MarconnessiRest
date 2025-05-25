# Progetto Marconnessi REST API

## Descrizione
Questo progetto fornisce un insieme di **API REST** per la gestione di utenti, annunci, ticket e risposte, utilizzando PHP con MySQLi.  
È pensato per essere eseguito in ambiente locale tramite XAMPP.

---

## Istruzioni per l’uso

### 1. Installazione e configurazione

- **Copia del progetto:**  
  Copia l’intera cartella del progetto nella directory `htdocs/` di XAMPP (es. `C:\xampp\htdocs\MarconnessiRest`).

- **Avvio dei servizi:**  
  Avvia il server **Apache** e il database **MySQL** dal pannello di controllo di XAMPP.

- **Importazione del database:**  
  Importa il file SQL fornito nel database MySQL tramite phpMyAdmin o un altro client.

- **Configurazione del database:**  
  Apri il file `config/database.php` e verifica i parametri di connessione:  
  ```php
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'nome_database';
