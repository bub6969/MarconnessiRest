<?php
class Annuncio {
    private $conn;
    private $table_name = "annunci";

    public $id_annuncio;
    public $oggetto_annuncio;
    public $corpo_annuncio;
    public $data_annuncio;
    public $id_persona;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
    $query = "INSERT INTO " . $this->table_name . " 
              (oggetto_annuncio, corpo_annuncio, id_persona, data_annuncio)
              VALUES (?, ?, ?, NOW())";

    $stmt = $this->conn->prepare($query);

    // Pulizia dei dati
    $this->oggetto_annuncio = htmlspecialchars(strip_tags($this->oggetto_annuncio));
    $this->corpo_annuncio = htmlspecialchars(strip_tags($this->corpo_annuncio));
    $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));

    // Bind dei parametri (s = stringa, i = intero)
    $stmt->bind_param("ssi", $this->oggetto_annuncio, $this->corpo_annuncio, $this->id_persona);

    return $stmt->execute();
}


    public function read() {
        $query = "SELECT a.*, p.nome, p.cognome 
                  FROM " . $this->table_name . " a
                  JOIN persone p ON a.id_persona = p.id_persona
                  ORDER BY a.data_annuncio DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
}
?>