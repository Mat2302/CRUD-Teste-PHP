<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="/CRUD-Teste-PHP/Client/Style/styles.css">

</head>
<body>
    <div class="container-busca">
        <h2>Boas Vindas!</h2>
        <form method="post"><br>
            Usuário:<br>
            <input type="text" name="user" id="user"><br><br>

            Senha:<br>
            <input type="password" name="pass" id="pass"><br><br>

            <input type="submit" class="btn-cadastra" value="Entrar"><br>
            <a href="../Server/User/cadastrar-usuario.php" class="criar-conta">Não possui login? Cadastre-se!</a>
        </form>
    </div>
    <script href="./Js/script.js"></script>
</body>
</html>

<?php
try {
    require_once('../Server/functions.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST["user"];
        $pass = $_POST["pass"];

        if (empty($user) || empty($pass)) {
            echo "<p align='center'>Os campos devem ser preenchidos!</p>";
        } else {
            loginUser($user, md5($pass));
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>