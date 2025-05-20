<?php
require_once('../../../Server/functions.php');
session_start();
verifyLogin($_SESSION['user'], $_SESSION['pass']);
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
    <link rel="stylesheet" href="../../Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="home-endereco.php?idCliente=<?php echo $idCliente?>">Voltar</a>
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
            <input type="radio" name="endereco" id="endereco" value="1" checked <?php echo ($endPrincipal == 1 ? "checked disabled" : "")?>> Principal
            <input type="radio" name="endereco" id="endereco" value="0" <?php echo ($endPrincipal == 1 ? "disabled" : "")?>> Adicional<br><br>
            <input type="submit" class="btn-cadastra" value="Salvar" onclick="insertAddress()">
        </form>
    </div>
    <script src="script-cadastrar.js"></script>
    <script src="/CRUD-Teste-PHP/Client/Js/script.js"></script>
</body>
</html>

<?php
// Logout
if (isset($_POST["logout"])) {
    session_destroy();
    header('location: ../../index.php');
    exit;
}
?>