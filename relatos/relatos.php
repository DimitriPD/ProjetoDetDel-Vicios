<?php 
    session_start();
    include_once(__DIR__ . "/../functions/index.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icones/detdelunity.jpeg" type="image/x-icon">

        <!-- link font family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Guntur:wght@300&family=Roboto:wght@100;300;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./relatos.css">
    <link rel="stylesheet" href="../filtros.css">

    <title>Projeto DetDelDel</title>
</head>

<body>
    <?php 
        if (!isset($_SESSION['id'])) {
            $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
            header('Location: ../index.php');
        }
    ?>

    <main class="container">
        <?php 
            createHeader($_SESSION['tipo_usuario']);
        ?>

        <div class="header-relatos">
            <h1>Relatos Feitos Pela Comunidade</h1>
            <?php 
                $itensVicio = selectFromDb(
                    conn: $conn,
                    atributos: "*",
                    tabela: "tb_vicios"
                );
                if ($itensVicio) {
                    echo "
                        <nav class='filtro-vicio'>                        
                            <ul class='list-filtro-vicio'>";

                            echo "<li class='filtro-vicio-item'> <a href='./relatos.php'> Todos </a> </li>";
                            while ($row = mysqli_fetch_assoc($itensVicio)) {
                                echo "<li class='filtro-vicio-item'> <a href='?idFiltro={$row['cod_vicio']}'> {$row['descricao_vicio']} </a> </li>";
                            };
                    echo '
                            </ul>
                        </nav>';
                }
            ?>
        </div>

        <div class="relatos-area">
            <?php 
                if (isset($_GET['idFiltro'])) {
                    $condicaoFiltro = " 
                    (u.cod_usuario = r.cod_usuario_relato AND 
                    r.cod_status_relato = 3 AND 
                    r.cod_identificacao_relato = ir.cod_identificacao_relato AND
                    rc.cod_relato = r.cod_relato AND 
                    (v.cod_vicio = rv.cod_vicio AND v.cod_vicio = {$_GET['idFiltro']}) AND
                    rv.cod_relato = r.cod_relato)
                    ";
                } else {
                    $condicaoFiltro = '
                    (u.cod_usuario = r.cod_usuario_relato AND 
                    r.cod_status_relato = 3 AND 
                    r.cod_identificacao_relato = ir.cod_identificacao_relato AND
                    rc.cod_relato = r.cod_relato AND 
                    (v.cod_vicio = rv.cod_vicio) AND
                    rv.cod_relato = r.cod_relato)
                    ';
                }

                $resultado =selectFromDb( 
                    conn: $conn,
                    atributos: '
                        u.nome_usuario,
                        r.conteudo_relato,
                        ir.descricao_identificacao,
                        r.esta_anonimo,
                        v.descricao_vicio,
                        COUNT(rc.cod_relato) as upvotes
                    ',
                    tabela: '
                        tb_relatos r, 
                        tb_usuarios u, 
                        tb_identificacoes_relato ir, 
                        tb_relato_curtidas rc, 
                        tb_vicios v, 
                        tb_relato_vicios rv
                    ',
                    condicao: $condicaoFiltro,
                    grupo: '
                        u.nome_usuario,
                        r.conteudo_relato,
                        ir.descricao_identificacao,
                        r.esta_anonimo,
                        v.descricao_vicio
                    ',
                    ordena: 'upvotes desc'
                );

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
                } else {
                    echo '<div> 
                        <h1> Nenhum Relato Encotrado! </h1>    
                        <h3> Tente Outro Filtro! </h3>
                    </div>';
                }
            ?>
        </div>
    </main>
</body>
</html>