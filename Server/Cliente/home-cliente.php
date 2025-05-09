<?php
session_start();

if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
    header('location: ../../Client/index.php');
    exit;
}

$username = $_SESSION['username'];
$id = $_SESSION['idUser'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Client/Style/styles.css">

</head>
<body>
    <form method="post">
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
    </form>
    <?php echo '<h2 class="welcome">Bem-vindo '.$username.'!</h2>';?>
    <div class="container-busca">
        <h2 class="cliente-H2">CRUD - Avaliação</h2>
        <form>
            <input type="button" value="Cadastrar Cliente" class="botao-home" onclick="window.open('/CRUD-Teste-PHP/Server/Cliente/cadastra.php', '_top')"><br><br>
            <input type="button" value="Consultar Cliente" class="botao-home" onclick="window.open('/CRUD-Teste-PHP/Server/Cliente/consulta.php', '_top')"><br><br>
            <?php
                if ($_SESSION['permissao'] == 2) {
                    echo '<a class="btn btn-light-home" href="../User/cadastrar-usuario.php?flag='.base64_encode($_SESSION['idUser']).'">Cadastrar Usuário</a>';
                }
            ?>
        </form>
    </div>
    <script src="/CRUD-Teste-PHP/Client/Js/script.js"></script>
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