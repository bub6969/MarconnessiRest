<?php
class Aula
{
    private $conn;
    private $table_name = "aule";

    // Proprietà dell'aula
    public $aula;
    public $id_edificio;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea una nuova aula
    public function createAula()
    {
        $query = "INSERT INTO " . $this->table_name . " (aula, id_edificio) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        // Pulizia dati
        $this->aula = htmlspecialchars(strip_tags($this->aula));
        $this->id_edificio = htmlspecialchars(strip_tags($this->id_edificio));

        $stmt->bind_param("ss", $this->aula, $this->id_edificio);

        return $stmt->execute();
    }

    // Elimina un'aula tramite il nome
    public function deleteAula()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE aula = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("s", $this->aula);

        return $stmt->execute();
    }

    // Leggi tutte le aule
    public function read()
    {
        $query = "SELECT id_aula, aula, id_edificio FROM aule";
        $result = $this->conn->query($query);
        return $result;
    }
}
?>
