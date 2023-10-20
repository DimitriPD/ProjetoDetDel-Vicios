function mudaForm() {
    document.querySelectorAll('.form-header').forEach(element => {
        element.classList.toggle('esconde-form')
    });

    document.querySelectorAll('.form').forEach(element => {
        element.classList.toggle('esconde-form')
    });

    mudaFormText()
}

function mudaFormText() {
    if (document.querySelectorAll('.form-header')[0].classList.contains('esconde-form')) {
        document.querySelector('.btn-muda-form').innerHTML = 'Entrar'
    } else {
        document.querySelector('.btn-muda-form').innerHTML = 'Cadastrar-se' 
    }
}

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

let p_senha = null
let p_email = null
const form_cadastra = document.querySelector("#form-cadastra");
form_cadastra.addEventListener('submit', (event) => {
    event.preventDefault()    

    const usuario = document.querySelector('#id_nome_usuario_cadastrar').value
    const email = document.querySelector('#id_email').value
    const senha = document.querySelector('#id_senha_cadastrar').value
    const nascimento = document.querySelector('#id_data_nascimento').value

    if (usuario.trim() === '' || email.trim() === '' || senha.trim() === '' || nascimento.trim() === '') {
        alert("Preencha todos os campos!")
        return false
    } 

    if (!checkEmail(email)) {
        if (p_email === null) {
            p_email = document.createElement('p')
            p_email.className = 'aviso-erro'
            p_email.innerHTML = 'Email inválido!.'
            document.querySelector('.aviso-email').appendChild(p_email)
            return false
        }
        return false
    }
    
    if (senha.length < 6) {
        if (p_senha === null) {
            p_senha = document.createElement('p')
            p_senha.className = 'aviso-erro'
            p_senha.innerHTML = 'Senha deve ter no mínimo 6 dígitos.'
            document.querySelector('.aviso-senha').appendChild(p_senha)
            return false
        }

        return false
    }

    alert("aaaaaaaaaaaaaa")
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
