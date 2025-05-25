<?php
class Risposta
{
    private $conn;
    private $table_name = "risposte";

    public $id_risposta;
    public $dataora;
    public $allegato;
    public $oggetto;
    public $corpo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea una risposta
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (dataora, allegato, oggetto, corpo) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;

        $this->dataora = htmlspecialchars(strip_tags($this->dataora));
        $this->oggetto = htmlspecialchars(strip_tags($this->oggetto));
        $this->corpo = htmlspecialchars(strip_tags($this->corpo));

        $stmt->bind_param("ssss", $this->dataora, $this->allegato, $this->oggetto, $this->corpo);

        return $stmt->execute();
    }

    // Leggi tutte le risposte
    public function read()
    {
        $query = "SELECT id_risposta, dataora, allegato, oggetto, corpo FROM " . $this->table_name . " ORDER BY dataora DESC";
        $result = $this->conn->query($query);
        return $result;
    }
}
?>