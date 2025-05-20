const h2 = document.querySelector('h2');
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
        h2.innerHTML = 'Enderecos de ' + result['NOME'] + ' - #' + idClient;
    } catch (error) {
        console.log('Erro na requisição do POST!', error);
    }
}

const welcome = () => {
    postData("/CRUD-Teste-PHP/Server/Endereco/home-endereco.php", "", idClient);
}
welcome();