<?php
require_once('../../../Server/functions.php');
session_start();
verifyLogin($_SESSION['user'], $_SESSION['pass']);
$idCliente = base64_decode($_GET["idCliente"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Endereço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="home-endereco.php?idCliente=<?php echo $idCliente?>">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div><!-- DIV PARA CASO NÃO HAJA ENDEREÇOS PARA ESSE CLIENTE! --></div>
    <br><br><br><br>
    <div class="container-consulta">
        <h2></h2>
        <form method="post">
            <table>
                <thead></thead>
                <tbody></tbody>
            </table>
        </form>
    </div>
    <script src="script-consulta.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
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