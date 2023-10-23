<?php 
    if (!isset($_SESSION['id']) && !isset($_SESSION['tipo_usario'])) {
        $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
        header('Location: ./index.php');
    }

    if ($_SESSION['tipo_usuario'] <= 2) {
        createHeader(["home", "relatos", "perguntas", "usuarios", "sair"]);
    } else {
        createHeader(["home", "relatos", "perguntas","sair"]);
    }
?>