<?php
try {
    require('../functions.php');
    $dataClient = json_decode(file_get_contents('php://input'), true);
    $idCliente = $dataClient['idCliente'];
    $nome = $dataClient['nome'];
    $cpf = $dataClient['cpf'];
    $rg = $dataClient['rg'];
    $email = $dataClient['email'];
    $telefoneUm = $dataClient['telefoneUm'];
    $telefoneDois = $dataClient['telefoneDois'];
    $dataNascimento = $dataClient['dataNascimento'];

    if (alterClient($nome, $cpf, $rg, $email, $telefoneUm, $telefoneDois, $dataNascimento, $idCliente)) {
        echo json_encode("Cliente alterado com sucesso!");
    }
} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}

?>