const params = new URLSearchParams(window.location.search);
const endPrincipal = atob(params.get("endPrincipal"));

const readFormData = () => {
    const formData = {};
    formData["endPrincipal"] = endPrincipal;
    formData["idCliente"] = document.getElementById('idCliente').value;
    formData["rua"] = document.getElementById('rua').value;
    formData["numero"] = document.getElementById('numero').value;
    formData["bairro"] = document.getElementById('bairro').value;
    formData["cidade"] = document.getElementById('cidade').value;
    formData["estado"] = document.getElementById('estado').value;
    formData["pais"] = document.getElementById('pais').value;
    formData["cep"] = document.getElementById('cep').value;
    formData["endereco"] = document.querySelector('input[name="endereco"]:checked').value;
    return formData;
}

const cleamFormData = () => {
    document.getElementById('rua').value = "";
    document.getElementById('numero').value = "";
    document.getElementById('bairro').value = "";
    document.getElementById('cidade').value = "";
    document.getElementById('estado').value = "";
    document.getElementById('pais').value = "";
    document.getElementById('cep').value = "";
}

const validateForm = (formData) => {
    let flag = true;
    if (formData["estado"].length != 2) {
        alert('O estado deve ser em siglas!');
        flag = false;
    }

    if (formData["cep"].length != 10) {
        alert('O CEP deve seguir o formato 12.345-678');
        flag = false;
    }
    return flag;
}

const postData = async (link, headers, body) => {
    try {
        event.preventDefault();
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
        const result = await response.json();
        alert(result);
    } catch (error) {
        console.log('Erro na requisição POST!', error);
    }
}

const insertAddress = () => {
    const response = readFormData();
    
    if (validateForm(response)) {
        postData("/CRUD-Teste-PHP/Server/Endereco/cadastra-endereco.php", "", response);
        cleamFormData();
    }
}
