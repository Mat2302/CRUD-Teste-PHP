<?php
try {
    require_once('../functions.php');
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents('php://input'), true);
        $nome = $data['nome'];
        $cpf = $data['cpf'];
        $rg = $data['rg'];
        $email = $data['email'];
        $telefoneUm = $data['telefoneUm'];
        $telefoneDois = $data['telefoneDois'];
        $dataNascimento = $data['dataNascimento'];
        $idUser = $data['idUser'];

        createClient($nome, $cpf, $rg, $email, $telefoneUm, $telefoneDois, $dataNascimento, $idUser);
    }

} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}
?>