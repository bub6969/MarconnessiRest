<?php
class Annuncio
{
    private $conn;
    private $table_name = "annunci";

    // Proprietà di un annuncio
    public $id_annuncio;
    public $oggetto_annuncio;
    public $corpo_annuncio;
    public $data_annuncio;
    public $id_persona;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Leggi tutti gli annunci
    public function read()
    {
        $query = "SELECT id_annuncio, oggetto_annuncio, corpo_annuncio, data_annuncio, id_persona 
                  FROM " . $this->table_name . " ORDER BY data_annuncio DESC";
        $result = $this->conn->query($query);
        return $result;
    }

    // Crea un nuovo annuncio
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (oggetto_annuncio, corpo_annuncio, data_annuncio, id_persona) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        // Pulizia dati
        $this->oggetto_annuncio = htmlspecialchars(strip_tags($this->oggetto_annuncio));
        $this->corpo_annuncio = htmlspecialchars(strip_tags($this->corpo_annuncio));
        $this->data_annuncio = htmlspecialchars(strip_tags($this->data_annuncio));
        $this->id_persona = htmlspecialchars(strip_tags($this->id_persona));

        $stmt->bind_param("sssi", $this->oggetto_annuncio, $this->corpo_annuncio, $this->data_annuncio, $this->id_persona);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET oggetto_annuncio=?, corpo_annuncio=?, data_annuncio=? WHERE id_annuncio=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;
        $stmt->bind_param("sssi", $this->oggetto_annuncio, $this->corpo_annuncio, $this->data_annuncio, $this->id_annuncio);
        return $stmt->execute();
    }
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_annuncio=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;
        $stmt->bind_param("i", $this->id_annuncio);
        return $stmt->execute();
    }
}
?>