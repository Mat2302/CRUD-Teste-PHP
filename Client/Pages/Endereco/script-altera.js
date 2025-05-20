const params = new URLSearchParams(window.location.search);
const idAddress = atob(params.get("idEndereco"));
const idClient = atob(params.get("idCliente"));

const postData = async (link, headers, body) => {
    try {
        event.preventDefault();
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
        const result = await response.json();
        if (result == 200) {
            window.alert('Endereço alterado com sucesso!');
            window.location.href = '/CRUD-Teste-PHP/Client/Pages/Endereco/consulta-endereco.php?idCliente='+btoa(idClient);
        } else {
            window.alert('Já existe um endereço igual cadastrado!');
        }
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

const postDataUpdate = async (link, headers, body) => {
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

const fillData = (data) => {
    document.getElementById('rua').value = data[0].RUA;
    document.getElementById('numero').value = data[0].NUMERO;
    document.getElementById('bairro').value = data[0].BAIRRO;
    document.getElementById('cidade').value = data[0].CIDADE;
    document.getElementById('estado').value = data[0].ESTADO;
    document.getElementById('pais').value = data[0].PAIS;
    document.getElementById('cep').value = data[0].CEP;
}

const readFormData = () => {
    const formData = {};
    formData["idCliente"] = idClient;
    formData["idEndereco"] = idAddress;
    formData["rua"] = document.getElementById('rua').value;
    formData["numero"] = document.getElementById('numero').value;
    formData["bairro"] = document.getElementById('bairro').value;
    formData["cidade"] = document.getElementById('cidade').value;
    formData["estado"] = document.getElementById('estado').value;
    formData["pais"] = document.getElementById('pais').value;
    formData["cep"] = document.getElementById('cep').value;
    return formData;
}

const getData = async (idAddress, idClient) => {
    const data = {};
    data["idEndereco"] = idAddress;
    data["idCliente"] = idClient;
    const dataAddress = await postDataUpdate("/CRUD-Teste-PHP/Server/Endereco/altera-endereco.php", "", data);
    fillData(dataAddress);
}
getData(idAddress, idClient);

const updateData = () => {
    const formData = readFormData();
    postData("/CRUD-Teste-PHP/Server/Endereco/altera-endereco-controller.php", "", formData);
}