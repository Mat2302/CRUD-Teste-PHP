<?php
try {
    session_start();
    require_once('../functions.php');
    if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
        header('location: ../../Client/index.php');
        exit;
    }
    
    if(isset($_GET["idEndereco"]) && isset($_GET["idCliente"])) {
        $idEndereco = base64_decode($_GET["idEndereco"]);
        $idCliente = base64_decode($_GET["idCliente"]);
        $result = selectAddressByClientAndAddressId($idEndereco, $idCliente);

        foreach ($result as $linha) {
            $rua = $linha['RUA'];
            $numero = $linha['NUMERO'];
            $cep = $linha['CEP'];
            $bairro = $linha['BAIRRO'];
            $cidade = $linha['CIDADE'];
            $estado = $linha['ESTADO'];
            $pais = $linha['PAIS'];
            $endPrincipal = $linha['ENDERECO_PRINCIPAL'];
            $endComum = $linha['ENDERECO_COMUM'];
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Alterar Endereço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Client/Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="consulta-endereco.php?idCliente=<?php echo base64_encode($idCliente)?>">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div class="container-form">
        <h2 class="form-H2">Alterar Endereço</h2>
        <form method="post">
            ID Cliente:<br>
            <input type="number" name="idCliente" id="idCliente" value="<?php echo $idCliente?>" disabled><br><br>

            Rua:<br>
            <input type="text" name="rua" id="rua" value="<?php echo $rua?>" required><br><br>

            Numero:<br>
            <input type="number" name="numero" id="numero" value="<?php echo $numero?>"><br><br>

            Bairro:<br>
            <input type="text" name="bairro" id="bairro" value="<?php echo $bairro?>"><br><br>

            Cidade:<br>
            <input type="text" name="cidade" id="cidade" value="<?php echo $cidade?>" required><br><br>

            Estado:<br>
            <input type="text" name="estado" id="estado" value="<?php echo $estado?>" required><br><br>

            País:<br>
            <input type="text" name="pais" id="pais" value="<?php echo $pais?>" required><br><br>

            CEP:<br>
            <input type="text" name="cep" id="cep" maxlength="10" value="<?php echo $cep?>"
                   title="12.345-678" placeholder="12.345-678" pattern="\d{2}.\d{3}-\d{3}"><br><br>

            Tipo de Endereço:<br>
            <input type="radio" name="endereco" id="endereco" value="1" disabled <?php echo ($endPrincipal == 1 ? "checked" : "")?>>Principal
            <input type="radio" name="endereco" id="endereco" value="0" disabled <?php echo ($endComum == 1 ? "checked" : "")?>>Adicional<br><br>
            <input type="submit" class="btn-cadastra" value="Salvar">
        </form>
    </div>
    <script src="/CRUD-Teste/Client/Js/script.js"></script>
</body>
</html>
<?php
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ruaUpd = $_POST['rua'];
        $numeroUpd = $_POST['numero'];
        $bairroUpd = $_POST['bairro'];
        $cidadeUpd = $_POST['cidade'];
        $estadoUpd = $_POST['estado'];
        $paisUpd = $_POST['pais'];
        $cepUpd = $_POST['cep'];
        $flag = 1;
        
        $scn_result = selectAddressByClientId($idCliente);
        
        foreach ($scn_result as $linha) {
            if ((strcasecmp($linha['RUA'], $ruaUpd) == 0) && (strcasecmp($linha['NUMERO'], $numeroUpd) == 0) &&
                (strcasecmp($linha['BAIRRO'], $bairroUpd)) == 0 && (strcasecmp($linha['CIDADE'], $bairroUpd == 0)) &&
                ($linha['ID_ENDERECO'] != $idEndereco)) {
                    $flag = 0;
            }
        }
        
        alterAddress($ruaUpd, $numeroUpd, $bairroUpd, $cidadeUpd, $estadoUpd, $paisUpd, $cepUpd, $idEndereco, $idCliente, $flag);
    }

    // Logout
    if (isset($_POST["logout"])) {
        session_destroy();
        header('location: ../../Client/index.php');
        exit;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>