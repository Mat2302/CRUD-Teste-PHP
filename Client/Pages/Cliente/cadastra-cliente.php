<?php
require_once('../../../Server/functions.php');
session_start();
$idUser = $_SESSION["idUser"];
verifyLogin($_SESSION['user'], $_SESSION['pass']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="home-cliente.php">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div class="container-form">
        <h2 class="form-H2">Cadastro de Clientes</h2>
        <form><br>
            <input type="number" name="idUser" id="idUser" value="<?php echo $_SESSION['idUser']?>" hidden>
            Nome:<br>
            <input type="text" name="name" id="name" placeholder="" required><br><br>

            CPF:<br>
            <input type="text" name="cpf" id="cpf" maxlength="14"
                   title="123.456.789-12" placeholder="123.456.789-12" pattern="\d{3}.\d{3}.\d{3}-\d{2}" required><br><br>

            RG:<br>
            <input type="text" name="rg" id="rg" maxlength="12"
                   title="12.345.678-x" placeholder="12.345.678-x" pattern="\d{2}.\d{3}.\d{3}-[0-9x]" required><br><br>

            Email:<br>
            <input type="text" name="email" id="email" placeholder="email@gmail.com"><br><br>

            Telefone 1:<br>
            <input type="text" name="telephoneOne" id="telephoneOne" maxlength="14"
                   title="(19)99999-9999" placeholder="(19)99999-9999" pattern="\(\d{2}\)\d{5}-\d{4}" required><br><br>

            Telefone 2:<br>
            <input type="text" name="telephoneTwo" id="telephoneTwo" maxlength="14"
                   title="(19)99999-9999" placeholder="(19)99999-9999" pattern="\(\d{2}\)\d{5}-\d{4}"><br><br>

            Data de Nascimento:<br>
            <input type="date" name="bornDate" id="bornDate" required><br><br>

            <input type="submit" class="btn-cadastra" value="Salvar" onclick="insertClient()">
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