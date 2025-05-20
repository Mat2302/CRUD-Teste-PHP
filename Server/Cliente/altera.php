<?php
try {
    require('../functions.php');
    $idCliente = json_decode(file_get_contents('php://input'), true);
    $result = selectClientById($idCliente);

    header('Content-Type: application/json');
    echo json_encode($result);
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>