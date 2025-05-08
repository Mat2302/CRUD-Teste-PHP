<?php
$flag = base64_decode($_GET["flag"]);

if ($flag) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Client/Style/styles.css">
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="../Cliente/home-cliente.php">Voltar</a>
        <?php
            if ($_SESSION['permissao'] == 2)
                echo '<p class="display-user">Usuario: '.$_SESSION['username'].'</p>';
        ?>
    </form>
    <div class="container-form">
        <h2 class="form-H2">Cadastrar Usuário</h2>
        <form method="post"><br>
            Nome de Usuário:<br>
            <input type="text" name="username" id="username"><br><br>

            Usuário:<br>
            <input type="text" name="user" id="user"><br><br>

            Senha:<br>
            <input type="password" name="pass" id="pass"><br><br>

            <?php
            if ($_SESSION['permissao'] == 2) {
                echo '<input type="radio" name="permissao" value="1"> Comum
                      <input type="radio" name="permissao" value="2"> Administrador';
            }
            ?>

            <input type="submit" class="btn-cadastra" value="Cadastrar">
        </form>
    </div>
</body>
</html>

<?php
try {
    require_once('../functions.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST["username"];
        $user = $_POST["user"];
        $pass = $_POST["pass"];
        $permissao = $_POST["permissao"];
        
        if (empty($username) || empty($user) || empty($pass)) {
            echo '<p align="center">Os campos devem ser preenchidos!</p>';
        } else {
            $pass = md5($pass);
            if (empty($permissao))
                createUser($username, $user, $pass, 1);
            else
                createUser($username, $user, $pass, $permissao);
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>