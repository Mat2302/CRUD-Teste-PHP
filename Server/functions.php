<?php

function mask($value, $mask) {
    $maskared = "";
    $aux = 0;
    for ($i = 0; $i <= (strlen($mask) - 1); ++$i) {
        if ($mask[$i] == "#") {
            if (isset($value[$aux])) {
                $maskared .= $value[$aux++];
            }
        } else if (isset($mask[$i])) {
            $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function loginUser($user, $pass) {
    try {
        include('connect.php');
        session_start();
        $stmt = $pdo->prepare('SELECT * FROM Users WHERE USUARIO = :usuario AND SENHA = :senha');
        $stmt->bindParam(":usuario", $user);
        $stmt->bindParam(":senha", $pass);
        $stmt->execute();
        $result = $stmt->fetch();

        if (empty($result) || strcmp($result['USUARIO'], $user) != 0) {
            echo "<p align='center'>Usuário ou Senha incorretos!</p>";
            unset($_SESSION['user']);
            unset($_SESSION['pass']);
            unset($_SESSION['idUser']);
            unset($_SESSION['username']);
            unset($_SESSION['permissao']);
        } else {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            $_SESSION['idUser'] = $result['ID_USER'];
            $_SESSION['permissao'] = $result['PERMISSAO'];
            $_SESSION['username'] = $result['NOME_USUARIO'];
            header('location: ../Server/Cliente/home-cliente.php');
            exit;
        }
        
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage() . '<br>';
    }
}

function createUser($username, $user, $pass, $permissao) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('INSERT INTO Users (USUARIO, NOME_USUARIO, SENHA, PERMISSAO)
                               VALUES (:user, :username, :pass, :permissao)');
        $stmt->bindParam(":user", $user);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":pass", $pass);
        $stmt->bindParam(":permissao", $permissao);
        
        if ($stmt->execute()) {
            echo '<p align="center">Usuário cadastrado com sucesso!</p>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function createClient($idUser, $nome, $cpf, $rg, $email, $telefoneUm, $telefoneDois, $dataNascimento) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('INSERT INTO Clientes (ID_USER, NOME, CPF, RG, EMAIL, TELEFONE_UM, TELEFONE_DOIS, DATA_DE_NASCIMENTO) 
                               VALUES (:idUser, :nome, :cpf, :rg, :email, :telefoneUm, :telefoneDois, :dataNascimento)');
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':rg', $rg);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefoneUm', $telefoneUm);
        $stmt->bindParam(':telefoneDois', $telefoneDois);
        $stmt->bindParam(':dataNascimento', $dataNascimento);

        if ($stmt->execute()) {
            $mensagem = "Cadastro realizado com sucesso!";
            echo "<script>mostrarPopup('$mensagem');</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function createAddress($idCliente, $rua, $numero, $cep, $bairro, $cidade, $estado, $pais, $principal, $comum, $mensagem) {
    include('connect.php');
    try {
        $stmt = $pdo->prepare('INSERT INTO Endereco (ID_CLIENTE, RUA, NUMERO, CEP, BAIRRO, CIDADE, ESTADO, PAIS,
                               ENDERECO_PRINCIPAL, ENDERECO_COMUM) VALUES (:idCliente, :rua, :numero, :cep, :bairro, :cidade, :estado,
                               :pais, :principal, :comum)');
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->bindParam(":rua", $rua);
        $stmt->bindParam(":numero", $numero);
        $stmt->bindParam(":cep", $cep);
        $stmt->bindParam(":bairro", $bairro);
        $stmt->bindParam(":cidade", $cidade);
        $stmt->bindParam(":estado", $estado);
        $stmt->bindParam(":pais", $pais);
        $stmt->bindParam(":principal", $principal);
        $stmt->bindParam(":comum", $comum);
        if ($stmt->execute()) {
            echo "<script>mostrarPopup('$mensagem');</script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectUser() {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT * FROM Users');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else
            throw new Exception('Falha na busca.');
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage();
    }
}

function selectPermission($idUser) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT PERMISSAO FROM Users WHERE ID_USER = :idUser');
        $stmt->bindParam(":idUser", $idUser);
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result['PERMISSAO'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectClientByName($nome, $idUser, $permissao) {
    try {
        include('connect.php');
        if ($permissao == 2) {
            $stmt = $pdo->prepare('SELECT * FROM Clientes ORDER BY ATIVO DESC');
        } else if (empty($nome)) {
            $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE ATIVO = 1 AND ID_USER = :idUser');
            $stmt->bindParam(":idUser", $idUser);
        } else {
            $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE NOME LIKE :nome AND ATIVO = 1 AND ID_USER = :idUser');
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":idUser", $idUser);
        }
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectClientById($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectNameClientById($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT NOME FROM Clientes WHERE ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectAddressByClientId($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT * FROM Endereco WHERE ID_CLIENTE = :idCliente ORDER BY ENDERECO_PRINCIPAL DESC');
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectAddressByClientAndAddressId($idEndereco, $idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT * FROM Endereco WHERE ID_ENDERECO = :idEndereco AND ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idEndereco", $idEndereco);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
        return $result;
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}

function selectMainAddressByClientAndAddressId($idEndereco, $idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT ENDERECO_PRINCIPAL FROM Endereco WHERE ID_ENDERECO = :idEndereco AND ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idEndereco", $idEndereco);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectAddressByClientIdAndCommomAddress($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('SELECT ID_ENDERECO, RUA, NUMERO, CIDADE, CEP FROM Endereco WHERE ID_CLIENTE = :idCliente AND ENDERECO_COMUM = 1');
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}

function alterClient($nomeUpd, $cpfUpd, $rgUpd, $emailUpd, $telefoneUmUpd, $telefoneDoisUpd, $dataNascimentoUpd, $idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('UPDATE Clientes SET NOME = :nome, CPF = :cpf, RG = :rg, EMAIL = :email, TELEFONE_UM = :telefoneUm,
                               TELEFONE_DOIS = :telefoneDois, DATA_DE_NASCIMENTO = :dataNascimento WHERE ID_CLIENTE = :idCliente');
        $stmt->bindParam(":nome", $nomeUpd);
        $stmt->bindParam(":cpf", $cpfUpd);
        $stmt->bindParam(":rg", $rgUpd);
        $stmt->bindParam(":email", $emailUpd);
        $stmt->bindParam(":telefoneUm", $telefoneUmUpd);
        $stmt->bindParam(":telefoneDois", $telefoneDoisUpd);
        $stmt->bindParam(":dataNascimento", $dataNascimentoUpd);
        $stmt->bindParam(":idCliente", $idCliente);
        if ($stmt->execute()) {
            header('location: consulta.php');
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function alterAddress($ruaUpd, $numeroUpd, $bairroUpd, $cidadeUpd, $estadoUpd, $paisUpd, $cepUpd, $idEndereco, $idCliente, $flag) {
    try {
        include('connect.php');
        if ($flag == 1) {
            $stmt = $pdo->prepare('UPDATE Endereco SET RUA = :rua, NUMERO = :numero, BAIRRO = :bairro, CIDADE = :cidade,
                                    ESTADO = :estado, PAIS = :pais, CEP = :cep WHERE ID_ENDERECO = :idEndereco
                                    AND ID_CLIENTE = :idCliente');
            $stmt->bindParam(":rua", $ruaUpd);
            $stmt->bindParam(":numero", $numeroUpd);
            $stmt->bindParam(":bairro", $bairroUpd);
            $stmt->bindParam(":cidade", $cidadeUpd);
            $stmt->bindParam(":estado", $estadoUpd);
            $stmt->bindParam(":pais", $paisUpd);
            $stmt->bindParam(":cep", $cepUpd);
            $stmt->bindParam(":idEndereco", $idEndereco);
            $stmt->bindParam(":idCliente", $idCliente);
            if ($stmt->execute()) {
                header('location: consulta-endereco.php?idCliente='.base64_encode($idCliente).'');
                exit;
            }
        } else {
            echo '<p align="center">Já existe um endereço igual para esse cliente!</p>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function alterMainAddress($idEndereco, $idEnderecoNovo, $idCliente) {
    try {
        include('connect.php');
        if ($idEnderecoNovo) {
            $stmt = $pdo->prepare('DELETE FROM Endereco WHERE ID_ENDERECO = :idEndereco AND ID_CLIENTE = :idCliente AND ENDERECO_PRINCIPAL = 1');
            $stmt->bindParam(":idEndereco", $idEndereco);
            $stmt->bindParam(":idCliente", $idCliente);
            $stmt->execute();
            
            $stmt = $pdo->prepare('UPDATE Endereco SET ENDERECO_PRINCIPAL = 1, ENDERECO_COMUM = 0
                            WHERE ID_ENDERECO = :idEnderecoNovo AND ID_CLIENTE = :idCliente');
            $stmt->bindParam(":idEnderecoNovo", $idEnderecoNovo);
            $stmt->bindParam(":idCliente", $idCliente);
            if ($stmt->execute()) {
                header('location: consulta-endereco.php?idCliente='.base64_encode($idCliente).'');
                exit;
            }
        } else {
            echo '<p align="center">Por favor, selecione um endereço comum para prosseguir com a exclusão!</p>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function enableClient($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('UPDATE Clientes SET ATIVO = 1 WHERE ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idCliente", $idCliente);
        
        if ($stmt->execute()) {
            header('location: consulta.php');
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function disableClient($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('UPDATE Clientes SET ATIVO = 0 WHERE ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idCliente", $idCliente);
        
        if ($stmt->execute()) {
            header('location: consulta.php');
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function deleteAddress($idEndereco, $idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('DELETE FROM Endereco WHERE ID_ENDERECO = :idEndereco AND ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idEndereco", $idEndereco);
        $stmt->bindParam(":idCliente", $idCliente);
        if ($stmt->execute()) {
            header('location: consulta-endereco.php?idCliente='.base64_encode($idCliente).'');
            exit;
        }
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function deleteMainAddress($idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('DELETE FROM Endereco WHERE ID_CLIENTE = :idCliente AND ENDERECO_PRINCIPAL = 1');
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>