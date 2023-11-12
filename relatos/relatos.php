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

    <script src="relatos.js" defer></script>

    <title>Projeto DetDelDel</title>
</head>

<body>
    <?php 
        if (!isset($_SESSION['id'])) {
            $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
            header('Location: ../index.php');
        }

        $dadosRelato = filter_input_array (INPUT_POST, FILTER_DEFAULT);

        if (!empty($dadosRelato)) {
            $_SESSION['conteudo_relato'] = $dadosRelato['conteudo-relato'];

            if (isset($dadosRelato['esta-anonimo'])) {
                $anonimo = 1;
            } else {
                $anonimo = 0;
            }

            $codRelatoAnterior = selectFromDb($conn, 'cod_relato', 'tb_relatos', null, 'cod_relato desc', 1);
                if ($codRelatoAnterior) {
                    while ($row = mysqli_fetch_assoc($codRelatoAnterior)) {
                        settype($row['cod_relato'],'integer');
                        $idRelato = $row['cod_relato'] + 1;
                    }
                }

            date_default_timezone_set('America/Sao_Paulo');
            $hora_envio = date("Y-m-d H:i:s");

            $codStatus = 1;
            
            $atributosRelato = "$idRelato, {$_SESSION['cod_usuario']}, '{$dadosRelato['conteudo-relato']}', {$dadosRelato['identificacao-selecionada']}, $codStatus, $anonimo, '$hora_envio', null, null, null";
            insertIntoDb(conn: $conn, tabela: 'tb_relatos', valores: $atributosRelato);

            $atributosRelatoVicios = "$idRelato, {$dadosRelato['vicios-selecionados']}";
            insertIntoDb(conn: $conn, tabela: 'tb_relato_vicios', valores: $atributosRelatoVicios);

            $atributosRelatoCurte = "{$_SESSION['cod_usuario']}, $idRelato";
            insertIntoDb(conn: $conn, tabela: 'tb_relato_curtidas', valores: $atributosRelatoCurte);

            header('location: ./relatos.php');
        }
    ?>

    <main class="container">
        <?php 
            createHeader($_SESSION['tipo_usuario'], $_SESSION['nome_usuario']);
        ?>

            <?php 
                $itensVicio = selectFromDb(
                    conn: $conn,
                    atributos: "*",
                    tabela: "tb_vicios"
                );
                if ($itensVicio) {
                    echo "
                        <nav class='filtro-vicio'>       
                            <p class='titulo-filtro'>Vícios</p>                 
                            <ul class='list-filtro-vicio'>";

                            echo "<li class='filtro-vicio-item'> <a href='./relatos.php'> <div class='checkbox'></div> Todos </a> </li>";
                            while ($row = mysqli_fetch_assoc($itensVicio)) {
                                echo "<li class='filtro-vicio-item'> <a href='?idFiltro={$row['cod_vicio']}'> <div class='checkbox'></div> {$row['descricao_vicio']} </a> </li>";
                            };
                    echo '
                            </ul>
                        </nav>';
                }
            ?>

        <div class="relatos-area">
            
            <div class='card-cria-relato'>
                    <div class='foto-perfil'>
                        <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
                    </div>

                    <form onsubmit="enviarRelato(event)" class='campo-texo' method="post">
                        <textarea name="conteudo-relato" id="" cols="100" rows="3" style='resize: none;' placeholder="Digite aqui seu relato..." value=
                        <?php
                            if (isset($_SESSION['conteudo-relato'])) {
                                echo $_SESSION['conteudo-relato'];
                                unset($_SESSION['conteudo-relato']);
                            } else {
                                echo '';
                            }
                        ?>
                        ></textarea>
                        <div class="parte-inferior">
                            <div class="escolhas-relato">
                                <ul>
                                    <li id='icone-vicios'> 
                                        <a href="#"> 
                                            <img src="../img/iconeCriaRelato/iconeVicios.png" alt=""> 
                                            <p>Vicíos</p>
                                        </a> 

                                        <div class="card-escolha-relato escolha-vicios esconde">
                                            <ul>
                                                <?php 
                                                    $ViciosnNoIcone = selectFromDb(
                                                        conn: $conn,
                                                        atributos: "*",
                                                        tabela: "tb_vicios"
                                                    );

                                                    if ($itensVicio) {
                                                        while ($row = mysqli_fetch_assoc($ViciosnNoIcone)) {
                                                            echo "
                                                            <li>
                                                                <input type='checkbox' name='vicios-selecionados' id='{$row['descricao_vicio']}' value='{$row['cod_vicio']}'> <label for='{$row['descricao_vicio']}'>{$row['descricao_vicio']}</label>
                                                            </li>";
                                                        };
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <li id='icone-identificacoes'>   
                                        <a href="#"> 
                                            <img src="../img/iconeCriaRelato/iconeIdentificacao.png" alt="">
                                            <p>Identificação</p>
                                        </a> 

                                        <div class="card-escolha-relato escolha-identificacoes esconde">
                                            <ul>
                                                <?php 
                                                    $ViciosnNoIcone = selectFromDb(
                                                        conn: $conn,
                                                        atributos: "*",
                                                        tabela: "tb_identificacoes_relato"
                                                    );

                                                    if ($itensVicio) {
                                                        while ($row = mysqli_fetch_assoc($ViciosnNoIcone)) {
                                                            echo "
                                                            <li>
                                                                <input type='checkbox' name='identificacao-selecionada' id='{$row['descricao_identificacao']}' value='{$row['cod_identificacao_relato']}'> 
                                                                <label for='{$row['descricao_identificacao']}'>{$row['descricao_identificacao']}</label>
                                                            </li>";
                                                        };
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <li id="icone-anonimo"> 
                                        <a href="#"> 
                                            <label for="anonimo-check">
                                                <img src="../img/iconeCriaRelato/iconeAnonimo.png" alt="">
                                                <p>Anônimo</p>
                                            </label>
                                            <input type="checkbox" name="esta-anonimo" id="anonimo-check">
                                        </a> 
                                    </li>
                                </ul>
                            </div>

                            <button type="submit" class='btn-publicar'>
                                Publicar
                            </button>
                        </div>
                    </form>

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
                        v.cod_vicio,
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
                            <div class='card-relato'>
                                <div class='foto-perfil-relato'>
                                    <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
                                </div>
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
                                            <p>{$row['descricao_identificacao']} A</p>
                                        </div>
                                    </div>

                                    <div class='downtext'>
                                        <div class='sobre-vicios'>
                                            <p id='{$row['cod_vicio']}'>{$row['descricao_vicio']}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class='conteudo-relato'>
                                    <div class='conteudo'>
                                        {$row['conteudo_relato']}
                                    </div>

                                    <div class='data-cidade-relato'>
                                        <p>{$row['nome_cidade']}</p>
                                        <p>{$row['data_envio']}</p>
                                    </div>
                                </div>

                                <div class='footer-relato'>
                                    <div class='upvote-area'>
                                        <p> {$row['upvotes']} </p>
                                        <a href='#' class='upvote'>
                                            <div class='upvote-interno'></div>
                                        </a>
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
        
        <div>
            <?php 
                
            ?>
        </div>

    </main>

    <script>
            const listaCheckBox = document.querySelectorAll('.checkbox')
            const teste = "<?php if (isset($_GET['idFiltro'])) {
                echo $_GET['idFiltro'];
            } ?>"
            listaCheckBox.forEach( (check, index) => {
                if (index == teste) {
                    check.classList.toggle('marcado')
                }                
            } )

            function teste2(inp) {
                console.log(inp.value)
            }
    </script>

</body>
</html>