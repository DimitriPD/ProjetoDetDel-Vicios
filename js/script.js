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



