<?php
class User {

    // Connessione al database e nome tabella
    private $conn;
    private $table_name = "persone";

    // Proprietà dell'oggetto utente
    public $id;
    public $mail;
    public $nome;
    public $cognome;
    public $data_nascita;
    public $ruolo;
    public $password;
    public $created;

    // Costruttore con connessione al database
    public function __construct($db){
        $this->conn = $db;
    }

    // Registrazione utente
    public function signup(){
        if($this->isAlreadyExist()){
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " (mail, nome, cognome, data_nascita, ruolo, password, created) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if($stmt === false) return false;

        // Pulizia dati
        $this->mail = htmlspecialchars(strip_tags($this->mail));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cognome = htmlspecialchars(strip_tags($this->cognome));
        $this->data_nascita = htmlspecialchars(strip_tags($this->data_nascita));
        $this->ruolo = htmlspecialchars(strip_tags($this->ruolo));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // Associazione dei parametri
        $stmt->bind_param("sssssss", $this->mail, $this->nome, $this->cognome, $this->data_nascita, $this->ruolo, $this->password, $this->created);

        if($stmt->execute()){
            $this->id = $stmt->insert_id;
            return true;
        }
        return false;
    }

    // Login utente
    public function login(){
        $query = "SELECT mail, password, nome, cognome, data_nascita, ruolo, created FROM " . $this->table_name . " WHERE mail = ? AND password = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        // Associazione dei parametri
        $stmt->bind_param("ss", $this->mail, $this->password);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Verifica se l'utente esiste già
    public function isAlreadyExist(){
        $query = "SELECT id_persona FROM " . $this->table_name . " WHERE mail = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        // Associazione dei parametri
        $stmt->bind_param("s", $this->mail);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Ottieni il nome dato l'email
    public function getNome($mail){
        $query = "SELECT nome FROM " . $this->table_name . " WHERE mail = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        // Associazione dei parametri
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Ottieni il cognome dato l'email
    public function getCognome($mail){
        $query = "SELECT cognome FROM " . $this->table_name . " WHERE mail = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        // Associazione dei parametri
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Ottieni l'email dato l'id
    public function getEmail($id){
        $query = "SELECT mail FROM " . $this->table_name . " WHERE id_persona = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Ottieni il ruolo dato l'email
    public function getRuolo($mail){
        $query = "SELECT r.ruolo FROM persone p JOIN ruoli r ON p.ruolo = r.id_ruolo WHERE p.mail = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        // Associazione dei parametri
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Ottieni l'orario settimanale associato alla mail dell'utente
    public function getOrarioByMail($mail){
        // Recupera la classe dell'utente tramite la tabella frequenta
        $query = "SELECT f.id_classe
                  FROM persone p
                  JOIN frequenta f ON p.id_persona = f.id_persona
                  WHERE p.mail = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt === false) return false;
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $id_classe = $row['id_classe'];
            // Query per l'orario settimanale della classe
            $queryOrario = "SELECT l.N_ora, l.giorno, m.nome_materia, a.aula
                            FROM lezioni l
                            JOIN materie m ON l.id_materia = m.id_materia
                            JOIN aule a ON l.id_aula = a.aula
                            WHERE l.id_classe = ?
                            ORDER BY l.giorno, l.N_ora";
            $stmtOrario = $this->conn->prepare($queryOrario);
            if($stmtOrario === false) return false;
            $stmtOrario->bind_param("i", $id_classe);
            $stmtOrario->execute();
            return $stmtOrario->get_result();
        } else {
            return false;
        }
    }
}
?>