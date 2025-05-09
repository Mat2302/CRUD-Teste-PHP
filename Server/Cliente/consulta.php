<?php
session_start();
if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
    header('location: ../../Client/index.php');
    exit;
}
$idUser = $_SESSION["idUser"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Client/Style/styles.css">
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
            Nome:<br>
            <input type="text" name="name" id="name"><br><br>
            <input type="submit" class="btn-cadastra" value="Consultar">
        </form>
    </div>
    <script src="/CRUD-Teste-PHP/Client/Js/script.js"></script>
    
</body>
</html>

<?php

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('../functions.php');
        $nome = $_POST["name"];
        $permissao = selectPermission($idUser);
        if (isset($nome))
            $result = selectClientByName($nome, $idUser, $permissao);

        if (empty($result))     {
            echo '<br><p align="center">Esse usuário não possui clientes cadastrados!</p>';
        } else {
            echo '
            <br><br><br>
            <div class="container-consulta">
            <form method="post">
                <table border="1px">
                        <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>Email</th>
                        <th>Telefone 1</th>
                        <th>Telefone 2</th>
                        <th>Data de Nascimento</th>
                        <th>Ações</th>
                        </tr>';

            foreach ($result as $linha) {
                echo '<tr>';
                echo '<td></td>';
                echo '<td>' . $linha['NOME'] , '</td>'  ;
                echo '<td>' . $linha['CPF'] . '</td>';
                echo '<td>' . $linha['RG'] . '</td>';
                echo '<td>' . $linha['EMAIL'] . '</td>';
                echo '<td>' . $linha['TELEFONE_UM'] . '</td>';
                echo '<td>' . $linha['TELEFONE_DOIS'] . '</td>';
                echo '<td>' . date('d/m/Y', strtotime($linha['DATA_DE_NASCIMENTO'])) . '</td>';
                echo '<td>
                        <a href="altera.php?idCliente='.base64_encode($linha['ID_CLIENTE']).'" class="btn btn-light btn-sm">Alterar</a>';
                        if ($permissao == 2) {
                            if ($linha['ATIVO'] == 1) {
                                echo '' . ($permissao == 2 ? '<a href="desativa.php?idCliente='.base64_encode($linha['ID_CLIENTE']).'"
                                                            class="btn btn-secondary btn-sm">Desativar</a>' : "") .'';
                            } else {
                                echo '' . ($permissao == 2 ? '<a href="ativa.php?idCliente='.base64_encode($linha['ID_CLIENTE']).'"
                                                            class="btn btn-secondary btn-sm">Ativar</a>' : "") .'';
                            }
                        }
                        echo '<a href="../Endereco/home-endereco.php?idCliente='.base64_encode($linha['ID_CLIENTE']).'"
                            class="btn btn-light btn-sm">Endereços';
                echo '</td>';
                echo '</tr>'; 
            }

            echo '</table>';
            echo '</form>';
            echo '</div>';
        }

        // Logout
        if (isset($_POST["logout"])) {
            session_destroy();
            header('location: ../../Client/index.php');
            exit;
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>