function mostraSenha(id_input, id_botao) {
    if (document.querySelector(`#${id_input}`).type === 'password') {
        document.querySelector(`#${id_input}`).type = 'text'
        document.querySelector(`#${id_botao}`).innerHTML = 'Esconder'
    } else {
        document.querySelector(`#${id_input}`).type = 'password'
        document.querySelector(`#${id_botao}`).innerHTML = 'Mostrar'
    }
}

const botoes_senha = document.querySelectorAll('.btn-mostra-senha')
botoes_senha.forEach(botao => {
    botao.addEventListener('keyup', e => {
        if (e.key === 'Enter') {
            e.target.click()
        }
    })
});

function checkEmail(email) {
    const rgx = /^[a-z0-9.]+@[a-z0-9]+\.[a-z]+?$/i
    return rgx.test(email)
} 

function checkData(data) {
    const anoAtual = new Date()
    const dataSep = data.split("-")
    const dia = dataSep[0]
    const mes = dataSep[1]
    const ano = dataSep[2]

    if (data.length < 10)  {
        return false
    }

    if (mes < 0 || mes > 12) {
        return false
    }

    if (ano > anoAtual.getFullYear() ||  ano < 1913) {
        return false
    }

    if (dia <= 0 || dia > 31) {
        return false
    }

    if ( (dia>=30) && (mes==2) ){
        return false;
    }

    if ( (dia==29) && (mes==2) && ( (ano % 4) != 0 ) ){
        return false;
    }

    if ( (dia==31) && ( (mes==2) || (mes==4) || (mes==6) || (mes==9) || (mes==11)  ) ){
        return false;
    }
    return true
}

let p_email = null
let p_senha = null
let p_dataNasc = null
const form_cadastra = document.querySelector("#form-cadastra");
form_cadastra.addEventListener('submit', (event) => {
    const nome_usuario = document.querySelector('#id_nome_usuario_cadastrar').value
    const email = document.querySelector('#id_email').value
    const senha_hash = document.querySelector('#id_senha_cadastrar').value
    const data_nascimento = document.querySelector('#id_data_nascimento').value

    if (nome_usuario.trim() === '' || email.trim() === '' || senha_hash.trim() === '' || data_nascimento.trim() === '') {
        event.preventDefault()   
        alert("Preencha todos os campos!")
        return false
    } 

    if (!checkEmail(email)) {
        event.preventDefault()   
        if (p_email === null) {
            p_email = document.createElement('p')
            p_email.className = 'aviso-erro'
            p_email.innerHTML = 'Email inválido!'
            document.querySelector('.aviso-email').appendChild(p_email)
            return false
              
        }
        return false
    }
    
    if (senha_hash.length < 6) {
        event.preventDefault()   
        if (p_senha === null) {
            p_senha = document.createElement('p')
            p_senha.className = 'aviso-erro'
            p_senha.innerHTML = 'Senha deve ter no mínimo 6 dígitos!'
            document.querySelector('.aviso-senha').appendChild(p_senha)
            return false
        }

        return false
    }

    if (!checkData(data_nascimento)) {
        event.preventDefault()   
        if (p_dataNasc === null) {
            p_dataNasc = document.createElement('p')
            p_dataNasc.className = 'aviso-erro'
            p_dataNasc.innerHTML = 'Data inserida é inválida!.'
            document.querySelector('.aviso-data').appendChild(p_dataNasc)
            return false
        }
        return false
    }
    window.location.reload(true);
})

document.querySelector('#id_email').addEventListener('input', () => {
    if (p_email !== null) {
        document.querySelector('.aviso-email').removeChild(p_email)
        p_email = null
    } 
})

document.querySelector('#id_senha_cadastrar').addEventListener('input', () => {
    if (p_senha !== null) {
        document.querySelector('.aviso-senha').removeChild(p_senha)
        p_senha = null
    } 
})

document.querySelector('#id_data_nascimento').addEventListener('input', () => {
    if (p_dataNasc !== null) {
        document.querySelector('.aviso-data').removeChild(p_dataNasc)
        p_dataNasc = null
    } 
})

function mascaraNasc(input) {
    let nasc = input.value

    if(isNaN(nasc[nasc.length - 1])){
        
        input.value = nasc.substring(0, nasc.length-1)
        return
    }
    
    input.setAttribute("maxlength", "10")
    if (nasc.length == 2) input.value += "-" 
    if (nasc.length == 5) input.value += "-" 
}