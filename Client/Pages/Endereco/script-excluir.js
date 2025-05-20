const thead = document.querySelector('thead');
const tbody = document.querySelector('tbody');
const div = document.getElementById('div-modal');
const params = new URLSearchParams(window.location.search);
const idClient = atob(params.get("idCliente"));
const idAddress = atob(params.get("idEndereco"));
const endPrincipal = atob(params.get("endPrincipal"));

const postDataDelete = async (link, headers, body) => {
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        });
        const result = await response.json();
        if (result) {
            alert(result);
            window.location.href = "consulta-endereco.php?idCliente="+btoa(idClient);
        }
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

const postData = async (link, headers, body) => {
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        })
        const result = await response.json();
        divAddress(result);
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

const divAddress = (result) => {
    if (endPrincipal == 0) {
        div.innerHTML += `
                        <div class="container-endereco">
                            <p>Endereço excluído com sucesso!</p>
                            <a class="btn btn-light" href="consulta-endereco.php?idCliente=`+btoa(idClient)+`">Voltar</a>
                        </div>`;
    } else {
        div.innerHTML += `<div class="container-endereco">
                            <p>Para excluir um endereço principal, você pode selecionar ou criar um endereço principal novo.</p>
                            <button type="button" class="btn btn-light" id="select-button">Selecionar Novo</button>
                            <a class="btn btn-light" href="cadastra-endereco.php?idCliente=`+btoa(idClient)+`&endPrincipal=`+btoa(1)+`">Cadastrar Novo</a>
                        </div>`;
        document.getElementById('select-button').onclick = () => defineTable(result); 
    }
}

const defineTable = (result) => {
    thead.innerHTML = `<tr>
                            <th>Rua</th>
                            <th>Número</th>
                            <th>Cidade</th>
                            <th>CEP</th>
                            <th>Ações</th>
                        </tr>`;
    let line = "";
    result.forEach(element => {
        line += `<tr>
                    <td>`+element["RUA"]+`</td>
                    <td>`+element["NUMERO"]+`</td>
                    <td>`+element["CIDADE"]+`</td>
                    <td>`+element["CEP"]+`</td>
                    <td><input type="button" class="btn btn-light btn-sm" value="Selecionar" onclick="selectAddress(`+element["ID_ENDERECO"]+`)"></td>
                </tr>`;
    });
    tbody.innerHTML = line;
}

const selectAddress = (idNewAddress) => {
    const dataAddress = {};
    dataAddress["idCliente"] = idClient;
    dataAddress["idEndereco"] = idAddress;
    dataAddress["idEnderecoNovo"] = idNewAddress;
    postDataDelete("/CRUD-Teste-PHP/Server/Endereco/excluir-endereco-controller.php", "", dataAddress);
}

const removeData = () => {
    const dataAddress = {};
    dataAddress["idEndereco"] = idAddress;
    dataAddress["idCliente"] = idClient;
    dataAddress["endPrincipal"] = endPrincipal;

    postData("/CRUD-Teste-PHP/Server/Endereco/excluir-endereco.php", "", dataAddress);
}
removeData();