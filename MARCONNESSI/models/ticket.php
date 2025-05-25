<?php
class Ticket
{
    private $conn;
    private $table_name = "domande";

    public $id_domanda;
    public $data;
    public $allegato;
    public $corpo;
    public $oggetto;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea un nuovo ticket
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (data, allegato, corpo, oggetto) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;

        $this->data = htmlspecialchars(strip_tags($this->data));
        $this->corpo = htmlspecialchars(strip_tags($this->corpo));
        $this->oggetto = htmlspecialchars(strip_tags($this->oggetto));

        $stmt->bind_param("ssss", $this->data, $this->allegato, $this->corpo, $this->oggetto);

        return $stmt->execute();
    }

    // Leggi tutti i ticket
    public function read()
    {
        $query = "SELECT id_domanda, data, allegato, corpo, oggetto FROM " . $this->table_name . " ORDER BY data DESC";
        $result = $this->conn->query($query);
        return $result;
    }
}
?>