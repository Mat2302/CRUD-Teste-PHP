const params = new URLSearchParams(window.location.search);
const idClient = params.get("idCliente");

async function postData(link, headers, body) {
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
        const result = await response.json();
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

async function postDataUpdate(link, headers, body) {
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
        const result = await response.json();
        return result;
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

const getData = async (idClient) => {
    const dataClient = await postDataUpdate("/CRUD-Teste-PHP/Server/Cliente/altera.php", "", idClient);
    document.getElementById('name').value = dataClient[0].NOME;
    document.getElementById('cpf').value = dataClient[0].CPF;
    document.getElementById('rg').value = dataClient[0].RG;
    document.getElementById('email').value = dataClient[0].EMAIL;
    document.getElementById('telephoneOne').value = dataClient[0].TELEFONE_UM;
    document.getElementById('telephoneTwo').value = dataClient[0].TELEFONE_DOIS;
    document.getElementById('bornDate').value = dataClient[0].DATA_DE_NASCIMENTO;
}
getData(idClient);

function readFormData() {
    const formData = {};
    formData['idCliente'] = idClient;
    formData['nome'] = document.getElementById('name').value;
    formData['cpf'] = document.getElementById('cpf').value;
    formData['rg'] = document.getElementById('rg').value;
    formData['email'] = document.getElementById('email').value;
    formData['telefoneUm'] = document.getElementById('telephoneOne').value;
    formData['telefoneDois'] = document.getElementById('telephoneTwo').value;
    formData['dataNascimento'] = document.getElementById('bornDate').value;
    return formData;
}

const updateClient = () => {
    const result = readFormData();
    postData("/CRUD-Teste-PHP/Server/Cliente/altera-cliente-controller.php", "", result);
    alert('Cliente alterado com sucesso!');
    window.open('consulta-cliente.php');
}
