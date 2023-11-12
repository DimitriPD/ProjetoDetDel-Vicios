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
