const cpfnull = document.getElementById('cpf')
const rgnull = document.getElementById('rg')
const telefoneumnull = document.getElementById('telephoneOne')
const telefonedoisnull = document.getElementById('telephoneTwo')
const cepnull = document.getElementById('cep')

if (cpfnull) {
    const cpf = document.querySelector('#cpf')

    cpf.addEventListener('keypress', () => {
        let cpflength = cpf.value.length

        if (cpflength === 3 || cpflength === 7)
            cpf.value += '.'
        else if (cpflength === 11)
            cpf.value += '-'
    })
}

if (rgnull) {
    const rg = document.querySelector('#rg')

    rg.addEventListener('keypress', () => {
        let rglength = rg.value.length
    
        if (rglength === 2 || rglength === 6) 
            rg.value += '.'
        else if (rglength === 10)
            rg.value += '-'
    })
}

if (telefoneumnull) {
    const telefoneum = document.querySelector('#telephoneOne')

    telefoneum.addEventListener('keypress', () => {
        let telefoneumlength = telefoneum.value.length

        if (telefoneumlength === 0) 
            telefoneum.value += '('
        else if (telefoneumlength === 3)
            telefoneum.value += ')'
        else if (telefoneumlength === 9)
            telefoneum.value += '-'
    })
}

if (telefonedoisnull) {
    const telefonedois = document.querySelector('#telephoneTwo')

    telefonedois.addEventListener('keypress', () => {
        let telefonedoislength = telefonedois.value.length

        if (telefonedoislength === 0) 
            telefonedois.value += '('
        else if (telefonedoislength === 3)
            telefonedois.value += ')'
        else if (telefonedoislength === 9)
            telefonedois.value += '-'
    })
}

if (cepnull) {
    const cep = document.querySelector('#cep')

    cep.addEventListener('keypress', () => {
        let ceplength = cep.value.length

        if (ceplength === 2)
            cep.value += '.'
        else if (ceplength === 6)
            cep.value += '-'
    })
}

function mostrarPopup(mensagem) {
    alert(mensagem);
}
