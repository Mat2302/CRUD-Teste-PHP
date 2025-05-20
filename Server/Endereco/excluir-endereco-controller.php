<?php
try {
    require_once('../functions.php');
    $dataAddress = json_decode(file_get_contents('php://input'), true);

    $idCliente = $dataAddress["idCliente"];
    $idEndereco = $dataAddress["idEndereco"];
    $idEnderecoNovo = $dataAddress["idEnderecoNovo"];

    alterMainAddress($idEndereco, $idEnderecoNovo, $idCliente);

    echo json_encode('Alteração realizada com sucesso!');
} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}
?>