<?php
class Database
{
    // Credenziali
    private $host = "localhost";
    private $db_name = "marconnessi";
    private $username = "root";
    // Password vuota per XAMPP
    private $password = "";
    public $conn;

    // Connessione al database
    public function getConnection()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Controlla la connessione
        if ($this->conn->connect_error) {
            die("Errore di connessione: " . $this->conn->connect_error);
        }

        // Imposta il charset
        $this->conn->set_charset("utf8");

        return $this->conn;
    }
}
?>
