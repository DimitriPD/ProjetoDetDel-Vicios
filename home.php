<?php 
    session_start();
    include_once('./components.php')
?>

<!DOCTYPE html>
<html lang="pt-BR">

<body>
    <?php 
        if (!isset($_SESSION['id']) && !isset($_SESSION['tipo_usario'])) {
            $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
            header('Location: ./index.php');
        }

        if ($_SESSION['tipo_usuario'] <= 2) {
            createHeader(["home", "relatos", "usuarios", "sair"]);
        } else {
            createHeader(["home", "relatos", "sair"]);
        }
    ?>
    <main class="container">
        <div class="session-message">
            <?php
                if (isset($_SESSION['msg-bloqueante'])) {
                    echo $_SESSION['msg-bloqueante'];
                    unset($_SESSION['msg-bloqueante']);
                } ;
            ?>
        </div>
        
        <h1>teste</h1>
    </main>
</body>
</html>