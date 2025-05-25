<?php
class Classe
{
    private $conn;
    private $table_name = "classi";

    // Proprietà della classe
    public $id_classe;
    public $classe;

    // Costruttore
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea una nuova classe
    public function createClasse()
    {
        $query = "INSERT INTO " . $this->table_name . " (classe) VALUES (?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        // Pulizia dati
        $this->classe = htmlspecialchars(strip_tags($this->classe));

        $stmt->bind_param("s", $this->classe);

        if ($stmt->execute()) {
            $this->id_classe = $stmt->insert_id;
            return true;
        }
        return false;
    }

    // Elimina una classe tramite id_classe
    public function deleteClasse()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_classe = ?";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param("i", $this->id_classe);

        return $stmt->execute();
    }

    // Leggi tutte le classi
    public function read()
    {
        $query = "SELECT id_classe, classe FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result;
    }
}
?>
