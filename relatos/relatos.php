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
            createHeader($_SESSION['tipo_usuario'], $_SESSION['nome_usuario']);
        ?>

        <!-- <div class="header-relatos">
            <h1>Relatos Feitos Pela Comunidade</h1>
            <?php 
                // $itensVicio = selectFromDb(
                //     conn: $conn,
                //     atributos: "*",
                //     tabela: "tb_vicios"
                // );
                // if ($itensVicio) {
                //     echo "
                //         <nav class='filtro-vicio'>                        
                //             <ul class='list-filtro-vicio'>";

                //             echo "<li class='filtro-vicio-item'> <a href='./relatos.php'> Todos </a> </li>";
                //             while ($row = mysqli_fetch_assoc($itensVicio)) {
                //                 echo "<li class='filtro-vicio-item'> <a href='?idFiltro={$row['cod_vicio']}'> {$row['descricao_vicio']} </a> </li>";
                //             };
                //     echo '
                //             </ul>
                //         </nav>';
                // }
            ?>
        </div> -->

        <div class="relatos-area">
            
            <div class='card-cria-relato'>
                <div class="parte-superior">
                    <div class='foto-perfil'>
                        <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
                    </div>
                    <div class='campo-texo'>
                        <textarea name="" id="" cols="100" rows="3" style='resize: none;' placeholder="Digite aqui seu relato..."></textarea>
                    </div>
                </div>
                <div class="parte-inferior">
                    <div class="escolhas-relato">
                        <ul>
                            <li> <a href="#"> 
                                <img src="../img/iconeCriaRelato/iconeVicios.png" alt=""> 
                                <p>Vicíos</p>
                            </a> </li>

                            <li> <a href="#"> 
                                <img src="../img/iconeCriaRelato/iconeIdentificacao.png" alt="">
                                <p>Identificação</p>
                             </a> </li>

                            <li> <a href="#"> 
                                <img src="../img/iconeCriaRelato/iconeAnonimo.png" alt="">
                                <p>Anônimo</p>
                            </a> </li>
                        </ul>
                    </div>

                    <a href="#" class='btn-publicar btn-publicar-relato'>
                        PUBLICAR
                    </a>
                </div>
            </div>

            <?php 
                if (isset($_GET['idFiltro'])) {
                    $condicaoFiltro = " 
                    (u.cod_usuario = r.cod_usuario_relato AND 
                    r.cod_status_relato = 3 AND 
                    r.cod_identificacao_relato = ir.cod_identificacao_relato AND
                    rc.cod_relato = r.cod_relato AND 
                    (v.cod_vicio = rv.cod_vicio AND v.cod_vicio = {$_GET['idFiltro']}) AND
                    rv.cod_relato = r.cod_relato) AND
                    c.cod_cidade = u.cod_cidade
                    ";
                } else {
                    $condicaoFiltro = '
                    (u.cod_usuario = r.cod_usuario_relato AND 
                    r.cod_status_relato = 3 AND 
                    r.cod_identificacao_relato = ir.cod_identificacao_relato AND
                    rc.cod_relato = r.cod_relato AND 
                    (v.cod_vicio = rv.cod_vicio) AND
                    rv.cod_relato = r.cod_relato) AND
                    c.cod_cidade = u.cod_cidade
                    ';
                }

                $resultado =selectFromDb( 
                    conn: $conn,
                    atributos: '
                        u.nome_usuario,
                        r.conteudo_relato,
                        r.esta_anonimo,
                        CAST(r.data_hora_envio AS DATE) as data_envio,
                        ir.descricao_identificacao,
                        v.descricao_vicio,
                        c.nome_cidade,
                        COUNT(rc.cod_relato) as upvotes
                    ',
                    tabela: '
                        tb_relatos r, 
                        tb_usuarios u, 
                        tb_identificacoes_relato ir, 
                        tb_relato_curtidas rc, 
                        tb_vicios v, 
                        tb_relato_vicios rv,
                        tb_cidades c
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
                            <div class='relato-base'>
                                <div class='foto-perfil'>
                                    <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
                                </div>

                                <div class='card-relato'>
                                    <div class='header-relato'>
                                        <div class='uptext'>
                                            <p>";
                                                if ($row['esta_anonimo'] == 1) {
                                                    echo "Anônimo";
                                                } else {
                                                    echo $row['nome_usuario'];
                                                }
                                            echo "</p>

                                            <div class='identificacao-relato'>
                                                <p>Identificação: </p>
                                                <p>{$row['descricao_identificacao']}</p>
                                            </div>
                                        </div>

                                        <div class='downtext'>
                                            <p> Sobre: </p>

                                            <div class='sobre-vicios'>
                                                <p>{$row['descricao_vicio']}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='conteudo-relato'>
                                        {$row['conteudo_relato']}
                                        {$row['conteudo_relato']}
                                        {$row['conteudo_relato']}
                                        {$row['conteudo_relato']}
                                    </div>

                                    <div class='footer-relato'>
                                        <div class='data-cidade-relato'>
                                            <p>{$row['nome_cidade']}</p>
                                            <p>{$row['data_envio']}</p>
                                        </div>

                                        <div class='upvote-area'>
                                            <p> {$row['upvotes']} </p>
                                            <a href='#' class='upvote'>
                                            
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>";
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