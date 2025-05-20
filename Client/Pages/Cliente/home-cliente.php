<?php
require_once('../../../Server/functions.php');
session_start();
verifyLogin($_SESSION['user'], $_SESSION['pass']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="/CRUD-Teste-PHP/Client/Style/styles.css">

</head>
<body>
    <form method="post">
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
    </form>
    <?php echo '<h2 class="welcome">Bem-vindo '.$_SESSION["username"].'!</h2>';?>
    <div class="container-busca">
        <h2 class="cliente-H2">CRUD - Avaliação</h2>
        <form>
            <input type="number" name="idUser" id="idUser" value="<?php echo $_SESSION['idUser']?>" hidden>
            <input type="button" value="Cadastrar Cliente" class="botao-home" onclick="window.open('/CRUD-Teste-PHP/Client/Pages/Cliente/cadastra-cliente.php', '_top')"><br><br>
            <input type="button" value="Consultar Cliente" class="botao-home" onclick="window.open('/CRUD-Teste-PHP/Client/Pages/Cliente/consulta-cliente.php', '_top')"><br><br>
            <?php
                if ($_SESSION['permissao'] == 2) {
                    echo '<a class="btn btn-light-home" href="../User/cadastrar-usuario.php?flag='.base64_encode($_SESSION['idUser']).'">Cadastrar Usuário</a><br><br>';
                    echo '<a class="btn btn-light-home" href="../../Client/Pages/Users/consulta-usuario.php">Consultar Usuário</a><br><br>';
                }
            ?>
        </form>
    </div>
    <script src="script-cliente.js"></script>
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