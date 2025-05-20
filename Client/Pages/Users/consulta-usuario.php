<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" ontent="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Style/styles.css">
    <title>Consulta Usuários</title>
</head>
<body>
    <form method="post">
        <a class="btn btn-light" href="/CRUD-Teste-PHP/Server/Cliente/home-cliente.php">Voltar</a>
        <input type="submit" class="btn btn-light" value="Logout" name="logout">
        <p class='display-user'>Usuario: <?php echo $_SESSION['username'];?></p>
    </form>
    <div class="container-consulta">
        <form method="post"><br>
            <h2>Lista de Usuários</h2>
            <table class="consulta-usuario">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuário</th>
                        <th>Nome de Usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </form>
    </div>
</body>
<script src="script-user.js"></script>
</html>

<?php
// Logout
if (isset($_POST["logout"])) {
    session_destroy();
    header('location: ../../index.php');
    exit;
}
?>