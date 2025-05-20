<?php
try {
    include('../connect.php');
    $stmt = $pdo->prepare('SELECT * FROM Users');
    $stmt->execute();
            
    $data = "";
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($result);

        $data .= "<table>
                    <tr>
                        <td>$ID_USER</td>
                        <td>$NOME_USUARIO</td>
                        <td>$USUARIO</td>
                        <td><button id='$ID_USER' type='button' class='btn btn-secondary btn-sm' onclick='deleteUser($ID_USER)'>Excluir</button>
                    </tr>
                </table>";
                echo '<script src="../../Client/Users/script-user.js"></script>';
    }
    echo $data;
} catch (Exception $e) {
    echo 'Exceção capturada: ' . $e->getMessage();
}
?>