<?php
try {
    require_once('../functions.php');
    if (isset($_GET['idCliente'])) {
        $idCliente = base64_decode($_GET['idCliente']);
        enableClient($idCliente);
    }
} catch (PDOException $e) {
    echo "Exceção capturada: " . $e->getMessage();
}
?>