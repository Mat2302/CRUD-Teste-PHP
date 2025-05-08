<?php
session_start();
require_once('../functions.php');
if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
    header('location: ../../Client/index.php');
    exit;
}

$idCliente = base64_decode($_GET["idCliente"]);
$result = selectNameClientById($idCliente);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endereços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Client/Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="../Cliente/home-cliente.php">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <?php echo '<h2 class="welcome">Endereços de '.$result['NOME'].' - #'.$idCliente.'</h2>';?>
    <div class="container-busca-endereco">
            <h2 class='endereco-H2'>CRUD - Endereços</h2>
            <form>
                <input type="button" value="Cadastrar Endereço" class="botao-endereco" onclick="window.open('/CRUD-Teste/Server/Endereco/cadastra-endereco.php?idCliente=<?php echo base64_encode($idCliente)?>', '_top')"><br><br>
                <input type="button" value="Consultar Endereço" class="botao-endereco" onclick="window.open('/CRUD-Teste/Server/Endereco/consulta-endereco.php?idCliente=<?php echo base64_encode($idCliente)?>', '_top')"><br><br>
            </form>
        </div>
        <script href="./Js/script.js"></script>
</body>
</html>

<?php
// Logout
if (isset($_POST["logout"])) {
    session_destroy();
    header('location: ../../Client/index.php');
    exit;
}
?>