<?php
try {
    require_once('../functions.php');
    $dataAddress = json_decode(file_get_contents('php://input'), true);
    $idCliente = $dataAddress["idCliente"];
    $idEndereco = $dataAddress["idEndereco"];

    $result = selectAddressByClientAndAddressId($idEndereco, $idCliente);

    echo json_encode($result);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>