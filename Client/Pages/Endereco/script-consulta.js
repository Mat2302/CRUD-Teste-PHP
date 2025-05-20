const h2 = document.querySelector('h2');
const div = document.querySelector('div');
const thead = document.querySelector('thead');
const tbody = document.querySelector('tbody');
const params = new URLSearchParams(window.location.search);
const idClient = atob(params.get("idCliente"));

const postDataDelete = async (link, headers, body) => {
    try {
        const response = await fetch(link, {
            method: "POST",
            headers: { headers },
            body: JSON.stringify(body),
        })
        const result = await response.json();
        console.log(result);
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
        showData(result);
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

const showData = (result) => {
    if (result.length == 0) {
        div.innerHTML = `
            <div class="container-endereco">
                <h2 class="form-H2">Esse cliente não possui endereços cadastrados!</h2>
                <button onclick="history.go(-1)">Voltar</button>
            </div>`;
    } else {
        let line = "";
        h2.innerHTML = 'Endereços do Cliente';
        thead.innerHTML = `
                    <tr>
                        <th>CEP</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado - País</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>`;
        result.forEach(element => {
            var address = element["ENDERECO_PRINCIPAL"] == 1 ? "Principal" : "Comum";
            line += `<tr>
                        <td>` + element['CEP'] + `</td>
                        <td>` + element["RUA"] + `</td>
                        <td>` + element["NUMERO"] + `</td>
                        <td>` + element["BAIRRO"] + `</td>
                        <td>` + element["CIDADE"] + `</td>
                        <td>` + element["ESTADO"] + ` - ` + element["PAIS"] + `</td>
                        <td>` + address + `</td>
                        <td>
                            <button class="btn btn-light-read btn-sm" onclick="openUpdatePage(`+element['ID_ENDERECO']+`, `+element['ID_CLIENTE']+`, `+element['ENDERECO_PRINCIPAL']+`)">Alterar</button>
                            <button class="btn btn-secundary-read btn-sm" onclick="openRemovePage(`+element['ID_ENDERECO']+`, `+element['ID_CLIENTE']+`, `+element['ENDERECO_PRINCIPAL']+`)">Excluir</button>
                        </td>
                     </tr>`;
        });
        tbody.innerHTML = line;
    }
}

const readData = () => {
    postData("/CRUD-Teste-PHP/Server/Endereco/consulta-endereco.php", "", idClient);
}
readData();

const openUpdatePage = (idAddress, idClient, endPrincipal) => {
    window.open('altera-endereco.php?idCliente='+btoa(idClient)+'&idEndereco='+btoa(idAddress)+'&endPrincipal='+btoa(endPrincipal), '_blank');
}

const openRemovePage = (idAddress, idClient, endPrincipal) => {
    if (endPrincipal == 0) {

    }
    window.open('excluir-endereco.php?idCliente='+btoa(idClient)+'&idEndereco='+btoa(idAddress)+'&endPrincipal='+btoa(endPrincipal), '_blank');
}