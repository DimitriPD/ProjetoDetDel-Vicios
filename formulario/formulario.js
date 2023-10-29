// Verifica o tipo do input, se for senha ao clicar no botão muda para texto e vice-versa
function mostraSenha(id_input, id_botao) {
    if (document.querySelector(`#${id_input}`).type === 'password') {
        document.querySelector(`#${id_input}`).type = 'text'
        document.querySelector(`#${id_botao}`).innerHTML = 'Esconder'
    } else {
        document.querySelector(`#${id_input}`).type = 'password'
        document.querySelector(`#${id_botao}`).innerHTML = 'Mostrar'
    }
}
// Faz com que os botões de 'mostrar senha' funcionem apertando Enter
const botoes_senha = document.querySelectorAll('.btn-mostra-senha')
botoes_senha.forEach(botao => {
    botao.addEventListener('keyup', e => {
        if (e.key === 'Enter') {
            e.target.click()
        }
    })
});
// Regex para validar email. Recebe o email como parametro se estiver certo retorna true caso contrario retorna falso
function checkEmail(email) {
    const rgx = /^[a-z0-9.]+@[a-z0-9]+\.[a-z]+?$/i
    return rgx.test(email)
} 
// Separa a data pelos '-' e valida a data recebida como parametro
function checkData(data) {
    const anoAtual = new Date()
    const dataSep = data.split("-")
    // Ex: 20-01-2001 
    const dia = dataSep[0] // 20 
    const mes = dataSep[1] // 01 
    const ano = dataSep[2] // 2001

    if (data.length < 10)  { // data menor que 10 caracteres
        return false
    }

    if (mes < 0 || mes > 12) { // mes maior 12 ou menor que 0
        return false
    }

    if (ano > anoAtual.getFullYear() ||  ano < 1913) { // ano maior que o ano atual ou menor que 1913
        return false
    }

    if (dia <= 0 || dia > 31) { // dia menor que 0 ou maior que 31
        return false
    }

    if ( (dia>=30) && (mes==2) ){ // dia maior que 29 em fevereiro
        return false;
    }

    if ( (dia==29) && (mes==2) && ( (ano % 4) != 0 ) ){ // dia 29 em ano não bissexto 
        return false;
    }

    if ( (dia==31) && ( (mes==2) || (mes==4) || (mes==6) || (mes==9) || (mes==11)  ) ) { // dia 31 em meses que vão até 30 no máximo
        return false;
    }
    
    return true // Caso não falhe em nenhuma verificação
}

class CriaElemento { // Classe para criar elemento HTML
    elemento // Atributo da classe
    constructor(elemento, classe, texto) {  // funcao de construcao do JS, entre parenteses o que precisa ser passado para criar o objeto
        this.elemento = document.createElement(elemento) // atributo recebe a criação da tag HTML especificada 
        this.elemento.className = classe // Adiciona uma classe nessa tag. classe HTML!
        this.elemento.innerHTML = texto // Adiciona um texto
    }
}

const aviso_email = new CriaElemento("p", 'aviso-erro', 'Email Inválido') //Elemento ou tag p; class='aviso-erro'; <p> Email Inválido </p>  
function mostraAvisoEmail(input) {
    if (!checkEmail(input.value) && input.value.length > 0) { // Sempre que algo for digitado verifica se esta no padrao da regex de email, (função checkEmail()) ta la em cima, se não estiver aparece o aviso na tela.
            document.querySelector('.aviso-email').appendChild(aviso_email.elemento) // Adiciona ao fim do elemento com a classe='aviso-email', a costante aviso_email que é um p 
    } else {
        if (document.querySelector('.aviso-email').querySelector('.aviso-erro') !== null) { // Se o que foi digitado esta de acordo com a regex e se o elemento com a classe='aviso-email' tiver um elemento com a classe='aviso-erro' (classe da constante aviso_email)
            document.querySelector('.aviso-email').removeChild(aviso_email.elemento) // Remove a constante que é o aviso do elemento
        }
    }

    if (document.querySelector('.aviso-email').querySelector('.aviso-erro-session') !== null) { 
        document.querySelector('.aviso-email').removeChild(document.querySelector('.aviso-erro-session'))
    }
}

const aviso_senha = new CriaElemento('p', 'aviso-erro', 'Senha deve ter mais que 6 caracteres!')  //Elemento ou tag p; class='aviso-erro'; <p> Senha deve ter mais que 6 caracteres! </p>  
function mostraAvisoSenha(input) {
    if (input.value.length < 6 && input.value.length > 0) {
        document.querySelector('.aviso-senha').appendChild(aviso_senha.elemento)
    } else {
        if (document.querySelector('.aviso-senha').querySelector('.aviso-erro') !== null) {
            document.querySelector('.aviso-senha').removeChild(aviso_senha.elemento)
        }
    }
} 

const aviso_dataNasc = new CriaElemento("p", 'aviso-erro', 'Data inválida!') //Elemento ou tag p; class='aviso-erro'; <p> Data inválida! </p>  
function mostraAvisoDataNasc(input) {
    if (!checkData(input.value) && input.value.length > 2) {
            document.querySelector('.aviso-data').appendChild(aviso_dataNasc.elemento)
    } else {
        if (document.querySelector('.aviso-data').querySelector('.aviso-erro')) {
            document.querySelector('.aviso-data').removeChild(aviso_dataNasc.elemento)
        }
    }
}

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

    if (!checkEmail(email) || senha_hash.length < 6 || !checkData(data_nascimento)) {
        event.preventDefault()   
        return false
    }
})