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
                $pesquisaDefault =selectFromDb( 
                    conn: $conn,
                    atributos: 'u.nome_usuario,
                    r.conteudo_relato,
                    ir.descricao_identificacao,
                    r.esta_anonimo,
                    v.descricao_vicio,
                    COUNT(rc.cod_relato) as upvotes
                    ',
                    tabela: 'tb_relatos r, tb_usuarios u, tb_identificacoes_relato ir, tb_relato_curtidas rc, tb_vicios v, tb_relato_vicios rv',
                    condicao: '(u.cod_usuario = r.cod_usuario_relato AND r.cod_status_relato = 3 AND r.cod_identificacao_relato = ir.cod_identificacao_relato AND rc.cod_relato = r.cod_relato AND v.cod_vicio = rv.cod_vicio AND rv.cod_relato = r.cod_relato)',
                    grupo: 'u.nome_usuario,
                    r.conteudo_relato,
                    ir.descricao_identificacao,
                    r.esta_anonimo,
                    v.descricao_vicio
                    ',
                    ordena: 'upvotes desc'
                );

                $resultado = $pesquisaDefault;

                if ($resultado) {
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "
                            <div class='card-relatos'>
                                <div class='card-relato-header'> 
                                    <h1>";
                                        if ($row['esta_anonimo'] == 1) {
                                            echo "Anônimo";
                                        } else {
                                            echo $row['nome_usuario'];
                                        }
                                    echo "</h1>
                                    <h3> Identificação: {$row['descricao_identificacao']}  </h3>
                                    <h4> Vicío Mencionado: {$row['descricao_vicio']} </h4>
                               </div>

                                <div class='card-relato-conteudo'>
                                    <div class='relato-conteudo'>
                                        {$row['conteudo_relato']}
                                        <div class='footer-relato'>
                                            <div class='qtd-upvotes'> {$row['upvotes']} </div>
                                            <div class='btn-upvote-area'>
                                                <div class='btn-upvote' tabindex='0'></div>
                                            </div>
                                        </div>
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