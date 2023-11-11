<?php 
// Cria o header da página, assim não tem que criar um header em cada página
function createHeader(string $tipo, string $nome='') {
    $links = [
        ["../relatos/relatos.php", "../img/iconeMenuNav/iconeRelato","Relatos"],
        ["../perguntas/perguntas.php", "../img/iconeMenuNav/iconePerguntas","Perguntas"],
        ["../paginasConteudo/paginaConteudo.php", "../img/iconeMenuNav/iconeConteudos","Conteúdos"],
        ["../locaisAtendimento/locaisAtendimento.php", "../img/iconeMenuNav/iconeLocaisAtend","Locais De Atendimento"], 
        ["../meuPerfil/meuPerfil.php", "../img/iconeMenuNav/iconeMeuPerfil","Meu Pefil"], 
        ["../locaisAtendimento/locaisAtendimento.php", "../img/iconeMenuNav/iconeAcessibilidade","Acessibilidade"], 
    ];
    
    if ($tipo <= 2) {
        array_push($links, ["../validarPublicacoes/validarPublicacoes.php", "../img/iconeMenuNav/iconeValidarPublicacoes","Validar Publicações"]);
        if ($tipo == 1) {
            array_push($links, ["../gerenciarUsuarios/usuarios.php",  "../img/iconeMenuNav/iconeGerenciarUsuarios","Gerenciar Usuários"]);
        };
    }

    if ($tipo == 3) {
        array_push($links, ["../responderPerguntas/responderPerguntas.php",  "../img/iconeMenuNav/iconeResponderPerguntas","Responder Perguntas"]);
    }

    echo "
        <header> 
            <div class='logo-header'>
                <div class='texto-simbolo'>
                    <div class=simbolo>
                        <img src='../img/logo/simbolo.png' alt=''>
                    </div>
                    <div class='texto'>
                        <p>Vícios E</p>
                        <p>Vivências</p>
                    </div>
                </div>

                <div class='rosto'>
                    <img src='../img/logo/rosto.png' alt=''>
                </div>
            </div>
    
            <nav>
                <ul class='nav-list'>";
                    foreach ($links as $link) {                  
                        echo "<li class='list-item'>
                            <a href='{$link[0]}'>
                                <div class='icone'> <img src='{$link[1]}.png' alt=''> </div>
                                <div class='texto'> {$link[2]} </div>
                            </a>
                        </li>";
                    }
            echo "</ul>
            </nav>

            <div class='perfil-menu-nav'>
                <div class='item-perfil'> <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt=''> </div>
                <div class='item-perfil'> $nome </div>
                <div class='item-perfil '>
                    <a href='#' onclick='criaCardOpPerfil()'  class='opcoes-perfil'> 
                        <div class='pontinho'></div>
                    </a>
                </div>
            </div>

            <div class='card-opcoes esconde'>
                <ul>
                    <li><a href='#'>Meu Perfil</a></li>
                    <li><a href='#'>Mais</a></li>
                    <li><a href='../sair.php' style='color: red;'>Sair</a></li>
                </ul>
            </div>
        </header> 
    ";
}
?>

<script>
    function criaCardOpPerfil() {
        document.querySelector('.card-opcoes').classList.toggle('esconde')
    }
</script>