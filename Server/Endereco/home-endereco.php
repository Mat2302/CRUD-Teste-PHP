<?php
try {
    require_once('../functions.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $idClient = json_decode(file_get_contents('php://input'), true);

        $result = selectNameClientById($idClient);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}
?>