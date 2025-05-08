<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
    header('location: ../../Client/index.php');
    exit;
}

$idCliente = base64_decode($_GET["idCliente"]);
$endPrincipal = base64_decode($_GET["endPrincipal"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Endereço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Client/Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="home-endereco.php?idCliente=<?php echo base64_encode($idCliente)?>">Voltar</a>
        <?php echo ($endPrincipal ? "" : '<input type="submit" class="btn btn-light" value="Logout" name="logout">')?>
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div class="container-form">
        <h2 class="form-H2">Cadastro de Endereços</h2>
        <form method="post">
            ID Cliente:<br>
            <input type="number" name="idCliente" id="idCliente" value="<?php echo $idCliente?>" disabled><br><br>

            Rua:<br>
            <input type="text" name="rua" id="rua" required><br><br>

            Numero:<br>
            <input type="number" name="numero" id="numero"><br><br>

            Bairro:<br>
            <input type="text" name="bairro" id="bairro"><br><br>

            Cidade:<br>
            <input type="text" name="cidade" id="cidade" required><br><br>

            Estado:<br>
            <input type="text" name="estado" id="estado" required><br><br>

            País:<br>
            <input type="text" name="pais" id="pais" required><br><br>

            CEP:<br>
            <input type="text" name="cep" id="cep" maxlength="10"
                   title="12.345-678" placeholder="12.345-678" pattern="\d{2}.\d{3}-\d{3}"><br><br>

            Tipo de Endereço:<br>
            <input type="radio" name="endereco" id="endereco" value="1" <?php echo ($endPrincipal == 1 ? "checked disabled" : "")?>> Principal
            <input type="radio" name="endereco" id="endereco" value="0" <?php echo ($endPrincipal == 1 ? "disabled" : "")?>> Adicional<br><br>
            <input type="submit" class="btn-cadastra" value="Salvar">
        </form>
    </div>
    <script src="/CRUD-Teste/Client/Js/script.js"></script>
</body>
</html>

<?php
try {
    require_once('../functions.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rua = $_POST["rua"];
        $numero = $_POST["numero"];
        $bairro = $_POST["bairro"];
        $cidade = $_POST["cidade"];
        $estado = $_POST["estado"];
        $pais = $_POST["pais"];
        $cep = $_POST["cep"];
        $tipo = $_POST["endereco"];
        $principal = 0; $comum = 1;
        $result = selectAddressByClientId($idCliente);

        if ($endPrincipal == 1) {
            deleteMainAddress($idCliente);
            $tipo = 0; $principal = 1; $comum = 0;
        }

        if ($tipo == 1 || empty($result)) {
            $principal = 1; $comum = 0;
            $mensagem = "Cadastrado com sucesso!";
            foreach($result as $linha) {
                if ($linha['ENDERECO_PRINCIPAL'] == 1) {
                    $principal = 0; $comum = 1;
                    $mensagem = "Esse cliente já possui endereço principal. Endereço cadastrado como comum!";
                } 
            }
        } else { $mensagem = "Cadastrado com sucesso!"; }

        foreach ($result as $linha) {
            $lRua = $linha['RUA']; $lNumero = $linha['NUMERO'];
            $lBairro = $linha['BAIRRO']; $lCidade = $linha['CIDADE'];

            if ((strcasecmp($rua, $lRua) == 0) && (strcasecmp($numero, $lNumero) == 0) &&
                (strcasecmp($bairro, $lBairro)) == 0 && (strcasecmp($cidade, $lCidade == 0))) {
                $principal = 0; $comum = 0;
                $mensagem = "Esse endereço já está cadastrado.";
                echo "<script>mostrarPopup('$mensagem');</script>";
            }
        }

        if ($principal == 1 || $comum == 1)
            createAddress($idCliente, $rua, $numero, $cep, $bairro, $cidade, $estado, $pais, $principal, $comum, $mensagem);
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