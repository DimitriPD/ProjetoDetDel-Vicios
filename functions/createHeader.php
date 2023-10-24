<?php 
// Cria o header da página, assim não tem que criar um header em cada página
function createHeader(string $tipo) {
    $links = [
        ["../relatos/relatos.php","Relatos"],
        ["../perguntas/perguntas.php","Perguntas"],
        ["../paginasConteudo/paginaConteudo.php","Conteudo"],
        ["../locaisAtendimento/locaisAtendimento.php","Locais Atendimento"], 
    ];
    
    if ($tipo <= 2) {
        array_push($links, ["../validarPublicacoes/validarPublicacoes.php","Validar Publicações"]);
        if ($tipo == 1) {
            array_push($links, ["../gerenciarUsuarios/usuarios.php", "Gerenciar Usuários"]);
        };
    }

    if ($tipo == 3) {
        array_push($links, ["../responderPerguntas/responderPerguntas.php", "Responder Perguntas"]);
    }

    array_push($links, ["../sair.php","Sair"]);
    echo "
        <header> 
            <div class='logo-header'>
                <h1>Logo</h1>
            </div>
    
            <nav>
                <ul class='nav-list'>";
                    foreach ($links as $link) {                  
                        echo "<li class='list-item'>
                            <a href='{$link[0]}'>{$link[1]}</a>
                        </li>";
                    }
            echo "</ul>
            </nav>
        </header> 
    ";
}

