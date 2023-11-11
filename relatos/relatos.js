document.querySelector('#icone-vicios').addEventListener('click', () => {
    document.querySelector('.escolha-vicios').classList.toggle('esconde')
})

document.querySelector('#icone-vicios').addEventListener('mouseleave', () => {
    document.querySelector('.escolha-vicios').classList.add('esconde')
})

document.querySelector('#icone-identificacoes').addEventListener('click', () => {
    document.querySelector('.escolha-identificacoes ').classList.toggle('esconde')
})

document.querySelector('#icone-identificacoes').addEventListener('mouseleave', () => {
    document.querySelector('.escolha-identificacoes ').classList.add('esconde')
})

function enviarRelato(event) {
    const conteudo = document.querySelector('textarea').value
    const viciosList = document.querySelector('#icone-vicios').querySelectorAll("ul input")
    const identificacoesList = document.querySelector('#icone-identificacoes').querySelectorAll("ul input")

    if (conteudo.trim() === '' || conteudo.length < 20 || conteudo.length > 3000) {
        event.preventDefault()
        alert("O relato deve ter no mínimo 20 caracteres")
        return
    }

    let viciosSelecionados = []
    for (const vicio of viciosList) {
        console.log(vicio.checked)
        if (vicio.checked) {
            viciosSelecionados.push(vicio.id)
        }
    }

    if (viciosSelecionados.length === 0) {
        event.preventDefault()
        alert("Selecione pelo menos um vicio")
        return
    }

    let identificacaoSelecionada = []
    for (const identificacao of identificacoesList) {
        if (identificacao.checked) {
            identificacaoSelecionada.push(identificacao.id)
        }
    }

    if (identificacaoSelecionada.length === 0) {
        event.preventDefault()
        alert("Selecione uma Identificacao do Relato")
        return
    }
    if (identificacaoSelecionada.length > 1) {
        event.preventDefault()
        alert("Selecione apenas uma Identificacao do Relato")
        return
    }    
}

const tagVicios = document.querySelectorAll('.sobre-vicios p')

tagVicios.forEach(tag => {
    if (tag.id == 1) {
        tag.style.backgroundColor = 'rgba(255, 0, 0, .65)'
    }

    if (tag.id == 2) {
        tag.style.backgroundColor = 'rgba(150, 75, 0, .65)'
    }
    
    if (tag.id == 3) {
        tag.style.backgroundColor = 'rgba(33, 39, 97, .65)'
    }

    if (tag.id == 4) {
        tag.style.backgroundColor = 'rgba(71, 136, 113, .65)'
    }

    if (tag.id == 5) {
        tag.style.backgroundColor = 'rgba(188, 114, 16, .65)'
    }

    if (tag.id == 6) {
        tag.style.backgroundColor = 'rgba(71, 136, 113, .65)'
    }

    if (tag.id == 7) {
        tag.style.backgroundColor = 'rgba(5, 0, 255, .65)'
    }

    if (tag.id == 8) {
        tag.style.backgroundColor = 'rgba(75, 7, 129, .65)'
    }

    if (tag.id == 9) {
        tag.style.backgroundColor = 'rgba(113, 0, 0, .65)'
    }

    if (tag.id == 10) {
        tag.style.backgroundColor = 'rgba(191, 65, 26, .65)'
    }
});