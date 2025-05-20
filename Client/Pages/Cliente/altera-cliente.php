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
    <title>CRUD - Atualizar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="consulta-cliente.php">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div class="container-form">
        <h2 class="form-H2">Atualizar Cadastro</h2>
        <form method="post">           
            Nome:<br>
            <input type="text" name="name" id="name" required><br><br>

            CPF:<br>
            <input type="text" name="cpf" id="cpf" maxlength="14"
                   title="123.456.789-12" placeholder="123.456.789-12" pattern="\d{3}.\d{3}.\d{3}-\d{2}"
                   value="<?php echo $cpf?>" required><br><br>

            RG:<br>
            <input type="text" name="rg" id="rg" maxlength="12"
                   title="12.345.678-x" placeholder="12.345.678-x" pattern="\d{2}.\d{3}.\d{3}-[0-9x]"
                   value="<?php echo $rg?>" required><br><br>

            Email:<br>
            <input type="text" name="email" id="email" placeholder="email@gmail.com" value="<?php echo $email?>"><br><br>

            Telefone 1:<br>
            <input type="text" name="telephoneOne" id="telephoneOne" value="<?php echo $telefoneUm?>"
                   maxlength="14" title="(19)99999-9999" placeholder="(19)99999-9999"
                   pattern="\(\d{2}\)\d{5}-\d{4}" required><br><br>

            Telefone 2:<br>
            <input type="text" name="telephoneTwo" id="telephoneTwo" value="<?php echo $telefoneDois?>"
                   maxlength="14" title="(19)99999-9999" placeholder="(19)99999-9999" pattern="\(\d{2}\)\d{5}-\d{4}"><br><br>

            Data de Nascimento:<br>
            <input type="date" name="bornDate" id="bornDate"
                   value="<?php echo $dataNascimento?>" required><br><br>

            <input type="button" class="btn-cadastra" value="Salvar" onclick="updateClient()">
        </form>
    </div>
    <script src="script-cliente-alterar.js"></script>
    <script src="/CRUD-Teste-PHP/Client/Js/script.js"></script>
</body>
</html
<?php
// Logout
if (isset($_POST["logout"])) {
    session_destroy();
    header('location: ../../index.php');
    exit;
}
?>>