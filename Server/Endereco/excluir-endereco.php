<?php
try {
    require_once('../functions.php');
    $dataAddress = json_decode(file_get_contents('php://input'), true);
    $idClient = $dataAddress["idCliente"];
    $idAddress = $dataAddress["idEndereco"];
    $endPrincipal = $dataAddress["endPrincipal"];

    if ($endPrincipal == 0) {
        deleteAddress($idAddress, $idClient);
    } else {
        $result = selectAddressByClientIdAndCommomAddress($idClient);
    }

    echo json_encode($result);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>