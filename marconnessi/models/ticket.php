<?php
class Ticket
{
    private $conn;
    private $table_name = "ticket";

    public $id;
    public $oggetto_domanda;
    public $data_domanda;
    public $domanda_txt;
    public $data_risposta;
    public $risposta_txt;
    public $id_persona;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Crea un nuovo ticket
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (oggetto_domanda, domanda_txt, id_persona) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;

        $this->oggetto_domanda = (strip_tags($this->oggetto_domanda));
        $this->domanda_txt = (strip_tags($this->domanda_txt));

        $stmt->bind_param("ssi", $this->oggetto_domanda, $this->domanda_txt, $this->id_persona);
        return $stmt->execute();
    }

    // Leggi tutti i ticket
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data_domanda DESC";
        return $this->conn->query($query);
    }

    // Leggi ticket per utente
    public function readByUser($id_persona)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_persona = ? ORDER BY data_domanda DESC";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;

        $stmt->bind_param("i", $id_persona);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Aggiorna la risposta a un ticket (usato da admin o docente)
    public function updateRisposta()
    {
        $query = "UPDATE " . $this->table_name . " SET risposta_txt = ?, data_risposta = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;

        $stmt->bind_param("ssi", $this->risposta_txt, $this->data_risposta, $this->id);

        return $stmt->execute();
    }

    // Elimina un ticket (solo se ammesso)
    public function delete($id_ticket)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) return false;

        $stmt->bind_param("i", $id_ticket);
        return $stmt->execute();
    }
}
?>
