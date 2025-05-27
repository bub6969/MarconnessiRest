<?php
class Materia
{
    private $conn;
    private $table_name = "materie";

    // Proprietà della materia
    public $id_materia;
    public $nome_materia;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea una nuova materia
    public function createMateria()
    {
        $query = "INSERT INTO " . $this->table_name . " (nome_materia) VALUES (?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        // Pulizia dati
        $this->nome_materia = htmlspecialchars(strip_tags($this->nome_materia));

        $stmt->bind_param("s", $this->nome_materia);

        if ($stmt->execute()) {
            $this->id_materia = $stmt->insert_id;
            return true;
        }
        return false;
    }

    // Elimina una materia tramite id_materia
    public function deleteMateria()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_materia = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("i", $this->id_materia);

        return $stmt->execute();
    }

    // Leggi tutte le materie
    public function read()
    {
        $query = "SELECT id_materia, nome_materia FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result;
    }
}
?>
