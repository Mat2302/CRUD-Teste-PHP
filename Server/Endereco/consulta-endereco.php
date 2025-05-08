<?php
try {
    session_start();
    require_once('../functions.php');
    if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
        header('location: ../../Client/index.php');
        exit;
    }

    $idCliente = base64_decode($_GET["idCliente"]);
    $result = selectAddressByClientId($idCliente);
    $scn_result = selectNameClientById($idCliente);
    
    echo '<form method="post">
            <a class="btn btn-light" href="home-endereco.php?idCliente='.base64_encode($idCliente).'">Voltar</a>
            <input type="submit" class="btn btn-light" value="Logout" name="logout">
            <p class="display-user">Usuario: '.$_SESSION['username'].'</p>
          </form>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
          <link rel="stylesheet" href="../../Client/Style/styles.css">';

    if(empty($result)) {
        echo '<br><br><br>';
        echo '<div class="container-endereco"
                <h2 class="form-H2">Esse cliente não possui endereços cadastrados!</h2><br><br>
                <button onclick="history.go(-1);">Voltar</button>
              </div>';
    } else {
        echo '
            <br><br><br><br><br>
            <div class="container-consulta">
            <h2>Endereços de '. $scn_result['NOME'].' - #'. $idCliente .'</h2>
            <form method="post">
                <table border="1px">
                        <tr>
                        <th>CEP</th>
                        <th>Rua</th>
                        <th>Numero</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado - País</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                        </tr>';
        
        foreach ($result as $linha) {
            echo '<tr>';
            echo '<td>' . $linha['CEP'] . '</td>';
            echo '<td>' . $linha['RUA'] . '</td>';
            echo '<td>' . $linha['NUMERO'] . '</td>';
            echo '<td>' . $linha['BAIRRO'] . '</td>';
            echo '<td>' . $linha['CIDADE'] . '</td>';
            echo '<td>' . $linha['ESTADO'] . " - " . $linha['PAIS'] . '</td>';
            echo '<td>' . ($linha['ENDERECO_PRINCIPAL'] == 1 ? "Principal" : "Comum") . '</td>';
            echo '<td>
                    <a href="altera-endereco.php?idEndereco='.base64_encode($linha['ID_ENDERECO']).'&idCliente='.
                             base64_encode($linha['ID_CLIENTE']).'" class="btn btn-light btn-sm">Alterar</a>
                    <a href="excluir-endereco.php?idEndereco='.base64_encode($linha['ID_ENDERECO']).'&idCliente='.
                             base64_encode($linha['ID_CLIENTE']).'" class="btn btn-secondary btn-sm">Excluir</a>';
            echo '</tr>';
        }

        echo '<script src="/CRUD-Teste/Client/Js/script.js"></script>';
        echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>';
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
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>