<?php
require_once('../functions.php');
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data["nome"];
    $idUser = $data["idUser"];
    $permissao = $data["permissao"];

    $result = selectClientByName($nome, $idUser, $permissao);

    header('Content-Type: application/json');
    echo json_encode($result);
}
?>