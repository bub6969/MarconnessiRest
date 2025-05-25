<?php
class Edificio
{
    private $conn;
    private $table_name = "edifici";

    // Proprietà della classe edificio
    public $id_edificio;
    public $edificio;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea un nuovo edificio
    public function createEdificio()
    {
        $query = "INSERT INTO " . $this->table_name . " (id_edificio, edificio) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        // Pulizia dati
        $this->id_edificio = htmlspecialchars(strip_tags($this->id_edificio));
        $this->edificio = htmlspecialchars(strip_tags($this->edificio));

        $stmt->bind_param("ss", $this->id_edificio, $this->edificio);

        return $stmt->execute();
    }

    // Elimina un edificio tramite id_edificio
    public function deleteEdificio()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_edificio = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("s", $this->id_edificio);

        return $stmt->execute();
    }

    // Legge tutti gli edifici
    public function read()
    {
        $query = "SELECT id_edificio, edificio FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result;
    }
}
?>
