<?php

function verifyLogin($user, $pass) {
    if (!isset($user) && !isset($pass))  {
        header('location: ../../index.php');
        exit;
    }
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
            header('location: /CRUD-Teste-PHP/Client/Pages/Cliente/home-cliente.php');
            exit;
        }
        
    } catch (Exception $e) {
        echo 'Exceção capturada: ' . $e->getMessage() . '<br>';
    }
}

function createUser($username, $user, $pass, $permissao) {
    try {
        include('connect.php');
        $result = selectUser();
        $flag = 1;

        foreach ($result as $linha) {
            if (strcmp($user, $linha['USUARIO']) == 0) {
                echo '<p align="center">Usuário já existente, não foi possível cadastrar!</p>';
                $flag = 0;
            }
        }

        if ($flag == 1) {
            $stmt = $pdo->prepare('INSERT INTO Users (USUARIO, NOME_USUARIO, SENHA, PERMISSAO)
                                   VALUES (:user, :username, :pass, :permissao)');
            $stmt->bindParam(":user", $user);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":pass", $pass);
            $stmt->bindParam(":permissao", $permissao);
            
            if ($stmt->execute()) {
                echo '<p align="center">Usuário cadastrado com sucesso!</p>';
            }
    }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function createClient($nome, $cpf, $rg, $email, $telefoneUm, $telefoneDois, $dataNascimento, $idUser) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('INSERT INTO Clientes (NOME, CPF, RG, EMAIL, TELEFONE_UM, TELEFONE_DOIS, DATA_DE_NASCIMENTO, ID_USER) 
                               VALUES (:nome, :cpf, :rg, :email, :telefoneUm, :telefoneDois, :dataNascimento, :idUser)');
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':rg', $rg);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefoneUm', $telefoneUm);
        $stmt->bindParam(':telefoneDois', $telefoneDois);
        $stmt->bindParam(':dataNascimento', $dataNascimento);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function createAddress($idCliente, $rua, $numero, $cep, $bairro, $cidade, $estado, $pais, $principal, $comum) {
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
        $stmt->execute();
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
        if ($permissao == 2 && empty($nome)) {
            $stmt = $pdo->prepare('SELECT * FROM Clientes ORDER BY ATIVO DESC');
        } else if ($permissao == 2) {
            $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE NOME = :nome ORDER BY ATIVO DESC');
            $stmt->bindparam(":nome", $nome);
        }
        
        if ($permissao == 1 && empty($nome)) {
            $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE ID_USER = :idUser ORDER BY ATIVO DESC');
            $stmt->bindParam(":idUser", $idUser);
        } else if ($permissao == 1) {
            $stmt = $pdo->prepare('SELECT * FROM Clientes WHERE NOME = :nome AND ID_USER = :idUser ORDER BY ATIVO DESC');
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
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function alterAddress($ruaUpd, $numeroUpd, $bairroUpd, $cidadeUpd, $estadoUpd, $paisUpd, $cepUpd, $idEndereco, $idCliente) {
    try {
        include('connect.php');
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
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function alterMainAddress($idEndereco, $idEnderecoNovo, $idCliente) {
    try {
        include('connect.php');
        $stmt = $pdo->prepare('DELETE FROM Endereco WHERE ID_ENDERECO = :idEndereco AND ID_CLIENTE = :idCliente AND ENDERECO_PRINCIPAL = 1');
        $stmt->bindParam(":idEndereco", $idEndereco);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        
        $stmt = $pdo->prepare('UPDATE Endereco SET ENDERECO_PRINCIPAL = 1, ENDERECO_COMUM = 0
                        WHERE ID_ENDERECO = :idEnderecoNovo AND ID_CLIENTE = :idCliente');
        $stmt->bindParam(":idEnderecoNovo", $idEnderecoNovo);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
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
        $stmt->execute();
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