<?php
try {
    require_once('../functions.php');
    $dataAddress = json_decode(file_get_contents('php://input'), true);
    $endPrincipal = $dataAddress["endPrincipal"];
    $idCliente = $dataAddress["idCliente"];
    $rua = $dataAddress["rua"];
    $numero = $dataAddress["numero"];
    $bairro = $dataAddress["bairro"];
    $cidade = $dataAddress["cidade"];
    $estado = $dataAddress["estado"];
    $pais = $dataAddress["pais"];
    $cep = $dataAddress["cep"];
    $principal = 0; $comum = 0;
    $result = selectAddressByClientId($idCliente);
    
    if ($dataAddress["endereco"] == 1) {
        $principal = 1; $comum = 0;
    } else {
        $principal = 0; $comum = 1;
    }

    if (empty($result)) {
        $mensagem = "Endereço cadastrado como principal!";
    } else {
        foreach ($result as $line) {
            if ($line['ENDERECO_PRINCIPAL'] == 1) {
                if ($endPrincipal == 1) {
                    deleteMainAddress($idCliente);
                    $principal = 1; $comum = 0;
                } else {
                    $principal = 0; $comum = 1;
                    $mensagem = "O cliente já possui endereço principal, o endereço atual foi cadastrado como secundário.";
                }
            } else {
                $mensagem = "Endereço cadastrado com sucesso!";
            }
        }
    }

    foreach ($result as $line) {
        $lRua = $line['RUA']; $lNumero = $line['NUMERO'];
        $lBairro = $line['BAIRRO']; $lCidade = $line['CIDADE'];
    
        if ((strcasecmp($rua, $lRua) == 0) && (strcasecmp($numero, $lNumero) == 0) &&
            (strcasecmp($bairro, $lBairro)) == 0 && (strcasecmp($cidade, $lCidade == 0))) {
            $principal = 0; $comum = 0;
            $mensagem = "Não é possível cadastrar um endereço igual!";
        }
    }

    if ($principal != 0 || $comum != 0) {
        createAddress($idCliente, $rua, $numero, $cep, $bairro, $cidade, $estado, $pais, $principal, $comum);
    }

    header('Content-Type: application/json');
    echo json_encode($mensagem);
} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}

?>