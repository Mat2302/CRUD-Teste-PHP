<?php
require_once('../../../Server/functions.php');
session_start();
verifyLogin($_SESSION['user'], $_SESSION['pass']);
$idCliente = $_GET["idCliente"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endereços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="../Cliente/home-cliente.php">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <h2 class="welcome"></h2>
    <div class="container-busca-endereco">
            <h2 class='endereco-H2'>CRUD - Endereços</h2>
            <form>
                <input type="button" value="Cadastrar Endereço" class="botao-endereco" onclick="window.open('/CRUD-Teste-PHP/Client/Pages/Endereco/cadastra-endereco.php?idCliente=<?php echo base64_encode($idCliente)?>', '_top')"><br><br>
                <input type="button" value="Consultar Endereço" class="botao-endereco" onclick="window.open('/CRUD-Teste-PHP/Client/Pages/Endereco/consulta-endereco.php?idCliente=<?php echo base64_encode($idCliente)?>', '_top')"><br><br>
            </form>
        </div>
        <script src="script-home.js"></script>
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