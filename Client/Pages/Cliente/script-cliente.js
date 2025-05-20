const thead = document.querySelector('thead');
const tbody = document.querySelector('tbody');

function readFormData() {
    const formData = {};
    formData['nome'] = document.getElementById('name').value;
    formData['cpf'] = document.getElementById('cpf').value;
    formData['rg'] = document.getElementById('rg').value;
    formData['email'] = document.getElementById('email').value;
    formData['telefoneUm'] = document.getElementById('telephoneOne').value;
    formData['telefoneDois'] = document.getElementById('telephoneTwo').value;
    formData['dataNascimento'] = document.getElementById('bornDate').value;
    return formData;
}

function readData() {
    const data = {}
    data["nome"] = document.getElementById('readName').value;
    data["idUser"] = document.getElementById('idUser').value;
    data["permissao"] = document.getElementById('permissao').value;
    return data;
}

function cleanFormData() {
    document.getElementById('name').value = "";
    document.getElementById('cpf').value = "";
    document.getElementById('rg').value = "";
    document.getElementById('email').value = "";
    document.getElementById('telephoneOne').value = "";
    document.getElementById('telephoneTwo').value = "";
    document.getElementById('bornDate').value = "";
}

function showData(result) {
    thead.innerHTML = "<tr><th></th><th>Nome</th><th>CPF</th><th>RG</th><th>Email</th><th>Telefone 1</th><th>Telefone 2</th><th>Data de Nascimento</th><th>Ações</th></tr>";
    let line = "";
    result.forEach(element => {
        line += `<tr>
                    <td></td>
                    <td>`+element['NOME']+`</td>
                    <td>`+element['CPF']+`</td>
                    <td>`+element['RG']+`</td>
                    <td>`+element['EMAIL']+`</td>
                    <td>`+element['TELEFONE_UM']+`</td>
                    <td>`+element['TELEFONE_DOIS']+`</td>
                    <td>`+element['DATA_DE_NASCIMENTO']+`</td>
                    <td>
                        <button class="btn btn-light-read btn-sm" onclick="updateClient(`+element['ID_CLIENTE']+`)">Alterar</button>`;
        if (element['ATIVO'] == 1)
            line += `<button class="btn btn-secundary-read btn-sm" onclick="disableClient(`+element['ID_CLIENTE']+`)">Desativar</button>`;
        else
            line += `<button class="btn btn-secundary-read btn-sm" onclick="enableClient(`+element['ID_CLIENTE']+`)">Ativar</button>`;
        line += `<button class="btn btn-light-read btn-sm" onclick="openHomeAddress(`+element['ID_CLIENTE']+`)">Endereços</button></td></tr>`;
    });
    tbody.innerHTML = line;
}

async function postData(link, headers, body) {
    event.preventDefault();
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

async function postDataWait(link, headers, body) {
    event.preventDefault();
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
        const result = await response.json();
        showData(result);
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

function insertClient() {
    let flag = true;
    const response = readFormData();
    response['idUser'] = document.getElementById('idUser').value;

    if (!response['nome']) {
        alert('O nome não pode ser vazio.')
        flag = false;
    }
    if (response['cpf'].length != 14 || !response['cpf']) {
        alert('Digite o CPF no formato correto (123.456.789-10)');
        flag = false;
    }

    if (response['rg'].length != 12 || !response['rg']) {
        alert('Digite o RG no formato correto (12.345.678-9)');
        flag = false;
    }

    if (!response['email']) {
        alert('O email não pode ser vazio!');
        flag = false;
    }

    if (response['telefoneUm'].length != 14 || !response['telefoneUm']) {
        alert('Digite o telefone no formato correto ((19)98765-4321)')
        flag = false;
    }

    if (!response['dataNascimento']) {
        alert('A data de nascimento não pode ser vazia.');
        flag = false;
    }

    if (flag) {
        postData("/CRUD-Teste-PHP/Server/Cliente/cadastra.php", "", response);
        alert('Cliente cadastrado com sucesso!');
        cleanFormData();
    }
}

function readClient() {
    const response = readData();
    postDataWait("/CRUD-Teste-PHP/Server/Cliente/consulta.php", "", response);
    document.getElementById('readName').value = "";
}

function updateClient(idCliente) {
    window.open('altera-cliente.php?idCliente='+idCliente, '_blank');
}

function disableClient(idCliente) {
    postData("/CRUD-Teste-PHP/Server/Cliente/desativa.php", "", idCliente);
    alert("Cliente desativado com sucesso!");
    readClient();
}

function enableClient(idCliente) {
    postData("/CRUD-Teste-PHP/Server/Cliente/ativa.php", "", idCliente);
    alert("Cliente ativado com sucesso!");
    readClient();
}

function openHomeAddress(idCliente) {
    window.open('/CRUD-Teste-PHP/Client/Pages/Endereco/home-endereco.php?idCliente='+idCliente);
}