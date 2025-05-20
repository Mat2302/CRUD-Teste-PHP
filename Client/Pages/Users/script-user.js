const tbody = document.querySelector('tbody');

const listUsers = async () => {
    const data = await fetch('/CRUD-Teste-PHP/Server/User/consulta-usuario.php');
    const response = await data.text();
    tbody.innerHTML = response;
}

const deleteUser = async (idUser) => {
    const response = await fetch('/CRUD-Teste-PHP/Server/User/excluir-usuario.php?idUser=' + idUser, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            ID_USER: idUser
        })
    });

    if (response) {
        listUsers();
    }
}   
listUsers();