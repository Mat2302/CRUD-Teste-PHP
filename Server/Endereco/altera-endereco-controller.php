<?php
try {
    require_once('../functions.php');
    $dataAddress = json_decode(file_get_contents('php://input'), true);
    $flag = 1;
    $idCliente = $dataAddress["idCliente"];
    $idEndereco = $dataAddress["idEndereco"];
    $rua = $dataAddress["rua"];
    $numero = $dataAddress["numero"];
    $bairro = $dataAddress["bairro"];
    $cidade = $dataAddress["cidade"];
    $estado = $dataAddress["estado"];
    $pais = $dataAddress["pais"];
    $cep = $dataAddress["cep"];
    $result = selectAddressByClientAndAddressId($idEndereco, $idCliente);

    foreach ($result as $line) {
        $lRua = $line['RUA']; $lNumero = $line['NUMERO'];
        $lBairro = $line['BAIRRO']; $lCidade = $line['CIDADE'];
    
        if ((strcasecmp($rua, $lRua) == 0) && (strcasecmp($numero, $lNumero) == 0) &&
            (strcasecmp($bairro, $lBairro)) == 0 && (strcasecmp($cidade, $lCidade == 0))) {
            $flag = 0;
        }
    }

    if ($flag == 1) {
        alterAddress($rua, $numero, $bairro, $cidade, $estado, $pais, $cep, $idEndereco, $idCliente);
        echo json_encode(http_response_code(200));
    } else {
        echo json_encode('Já existe um endereço igual cadastrado!');
    }
} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}

?>