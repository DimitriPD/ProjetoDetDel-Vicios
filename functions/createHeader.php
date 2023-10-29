<?php 
// Cria o header da página, assim não tem que criar um header em cada página
function createHeader(string $tipo) {
    $links = [
        ["../relatos/relatos.php", "../img/iconeMenuNav/iconeRelato","Relatos"],
        ["../perguntas/perguntas.php", "../img/iconeMenuNav/iconePerguntas","Perguntas"],
        ["../paginasConteudo/paginaConteudo.php", "../img/iconeMenuNav/iconeConteudos","Conteúdos"],
        ["../locaisAtendimento/locaisAtendimento.php", "../img/iconeMenuNav/iconeLocaisAtend","Locais De Atendimento"], 
        ["../locaisAtendimento/locaisAtendimento.php", "../img/iconeMenuNav/iconeMeuPerfil","Meu Pefil"], 
        ["../locaisAtendimento/locaisAtendimento.php", "../img/iconeMenuNav/iconeAcessibilidade","Acessibilidade"], 
    ];
    
    if ($tipo <= 2) {
        array_push($links, ["../validarPublicacoes/validarPublicacoes.php", "../img/iconeMenuNav/icone","Validar Publicações"]);
        if ($tipo == 1) {
            array_push($links, ["../gerenciarUsuarios/usuarios.php",  "../img/iconeMenuNav/icone","Gerenciar Usuários"]);
        };
    }

    if ($tipo == 3) {
        array_push($links, ["../responderPerguntas/responderPerguntas.php",  "../img/iconeMenuNav/icone","Responder Perguntas"]);
    }

    array_push($links, ["../sair.php", "../img/iconeMenuNav/icone","Sair"]);
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
                                <div class='icone'> <img src='{$link[1]}.png' alt='F'> </div>
                                <div class='texto'> {$link[2]} </div>
                            </a>
                        </li>";
                    }
            echo "</ul>
            </nav>

            <div class='perfil-menu-nav'>
                    a
            </div>
        </header> 
    ";
}

