
<?php
header("Content-Type: application/json; charset=UTF-8");
include_once "../../../config/database.php";
include_once "../../../models/annuncio.php";

$database = new Database();
$db = $database->getConnection();
$annuncio = new Annuncio($db);

$result = $annuncio->read();
$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}
echo json_encode(["records" => $records]);
?>