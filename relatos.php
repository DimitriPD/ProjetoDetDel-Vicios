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
                    ir.descricao_identificacao,
                    r.esta_anonimo
                    ',
                    'tb_relatos r, tb_usuarios u, tb_identificacoes_relato ir',
                    '(u.cod_usuario = r.cod_usuario_relato AND r.cod_status_relato = 3 AND r.cod_identificacao_relato = ir.cod_identificacao_relato)'
                );

                if ($resultado) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "
                            <div class='card-relatos'>
                                <div class='card-relato-header'>
                                    <h1> {$row['nome_usuario']} </h1>
                                    <h3> Identificação: {$row['descricao_identificacao']}  </h3>
                                    <h4> {$row['esta_anonimo']} </h4>
                               </div>

                                <div class='card-relato-conteudo'>
                                    <div class='relato-conteudo'>
                                        {$row['conteudo_relato']}
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                }
            ?>
        </div>
    </main>
</body>
</html>