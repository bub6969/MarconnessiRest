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
                  SET oggetto_annuncio=:oggetto, corpo_annuncio=:corpo, 
                      id_persona=:id_persona, data_annuncio=NOW()";
        
        $stmt = $this->conn->prepare($query);
        
        $this->oggetto_annuncio = htmlspecialchars(strip_tags($this->oggetto_annuncio));
        $this->corpo_annuncio = htmlspecialchars(strip_tags($this->corpo_annuncio));
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));
        
        $stmt->bindParam(":oggetto", $this->oggetto_annuncio);
        $stmt->bindParam(":corpo", $this->corpo_annuncio);
        $stmt->bindParam(":id_persona", $this->id_persona);
        
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