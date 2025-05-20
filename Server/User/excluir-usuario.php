<?php
try {
    session_start();
    include('../connect.php');
    $idUser = filter_input(INPUT_GET, "idUser", FILTER_SANITIZE_NUMBER_INT);

    $data = "";
    $stmt = $pdo->prepare('DELETE FROM Users WHERE ID_USER = :idUser');
    $stmt->bindParam(":idUser", $idUser);
    if ($stmt->execute()) {
        $data .= "Usuário excluído com sucesso!";
    }
    echo $data;
} catch(PDOException $e) {
    echo "Exceção capturada: " . $e->getMessage();
}

?>