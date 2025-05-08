<?php
try {
    session_start();
    require_once('../functions.php');
    if (!isset($_SESSION['user']) && !isset($_SESSION['pass']))  {
        header('location: ../../Client/index.php');
        exit;
    }

    $idEndereco = base64_decode($_GET["idEndereco"]);
    $idCliente = base64_decode($_GET["idCliente"]);
    $scn_result = selectAddressByClientIdAndCommomAddress($idCliente);
    $result = selectMainAddressByClientAndAddressId($idEndereco, $idCliente);

    if ($result['ENDERECO_PRINCIPAL'] == 1) {
        echo '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
            <link rel="stylesheet" href="../../Client/Style/styles.css">
            <a class="btn btn-light" href="consulta-endereco.php?idCliente='.base64_encode($idCliente).'">Voltar</a>
            <p class="display-user">Usuario: '.$_SESSION['username'].'</p>
            <br><br><br><br><br>
            <div class="container-endereco">
                <p>Para excluir um endereço principal, você pode selecionar ou criar um endereço principal novo.</p>
                <a type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Selecionar Novo
                </a>
                <a href="cadastra-endereco.php?idCliente='.base64_encode($idCliente).'&endPrincipal='.base64_encode(1).'" class="btn btn-light">Cadastrar Novo</a>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Endereços adicionais</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">';
        if (empty($scn_result)) {
            echo '<p align="center">Esse cliente não possui endereço comum cadastrado!</p>';
        } else {
            foreach ($scn_result as $linha) {
                echo '<form method="post">';
                    echo '<input type="radio" name="enderecoNovo" id="enderecoNovo" value="'.$linha['ID_ENDERECO'].'">   ';
                    echo $linha['RUA'] . ', Nº' . $linha['NUMERO'] . '<br>';
                    echo '<label>' . $linha['CIDADE'] . ", " . mask($linha['CEP'], "##.###-###") . '</label>';
                    echo '<br><br>';
            }
        }
        echo '
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-add" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-secondary"'. (empty($scn_result) ? "disabled" : "") .'>Salvar Endereço</button>
                </form>
                </div>
                </div>
            </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        ';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idEnderecoNovo = $_POST['enderecoNovo'];
            alterMainAddress($idEndereco, $idEnderecoNovo, $idCliente);
        }
    } else {
        deleteAddress($idEndereco, $idCliente);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>