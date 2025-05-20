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
    <title>CRUD - Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="home-cliente.php">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div class="container-busca">
        <h2 class="form-H2">Consultar Clientes</h2>
        <form method="post">
            <input type="number" name="idUser" id="idUser" value="<?php echo $_SESSION['idUser']?>" hidden>
            <input type="number" name="permissao" id="permissao" value="<?php echo $_SESSION['permissao']?>" hidden>
            Nome:<br>
            <input type="text" name="readName" id="readName"><br><br>
            <input type="submit" class="btn-cadastra" value="Consultar" onclick="readClient()">
        </form>
    </div>

    <br><br><br>
    <div class="container-consulta">
        <form method="post">
            <table>
                <thead></thead>
                <tbody></tbody>
            </table>
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