<?php
try {
    require_once('../functions.php');
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $idCliente = json_decode(file_get_contents('php://input'), true);
        enableClient($idCliente);
    }
} catch (PDOException $e) {
    echo "Exceção capturada: " . $e->getMessage();
}
?>