<?php 
    session_start();
    include_once("./components.php");
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
        <div class="relatos-area">
            <?php 
                $resultado = selectFromDb(
                    $conn,
                    'u.nome_usuario,
                    r.conteudo_relato,
                    r.cod_identificacao_relato,
                    r.esta_anonimo
                    ',
                    'tb_relatos r, tb_usuarios u',
                    '(u.cod_usuario = r.cod_usuario_relato AND r.cod_status_relato = 3)'
                );

                if ($resultado) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo$row['nome_usuario'] . "<br>"; 
                        echo$row['conteudo_relato'] . "<br>";
                        echo$row['cod_identificacao_relato'] . "<br>";
                        echo$row['esta_anonimo'] . "<br>";
                    }
                }
            ?>
        </div>
    </main>
</body>
</html>