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
    <script src="../utils/tags.js" defer></script>

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

            

            foreach ($dadosRelato['vicios-selecionados'] as $vicioSelecionado) {
                $atributosRelatoVicios = "$idRelato, $vicioSelecionado";
                insertIntoDb(conn: $conn, tabela: 'tb_relato_vicios', valores: $atributosRelatoVicios);
            };
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

                        echo "<li class='filtro-vicio-item'> <a href='?idFiltro=0'> <div class='checkbox'></div> Todos </a> </li>";
                        while ($row = mysqli_fetch_assoc($itensVicio)) {
                            echo "<li class='filtro-vicio-item'> <a href='?idFiltro={$row['cod_vicio']}'> <div class='checkbox'></div> {$row['descricao_vicio']} </a> </li>";
                        };
                echo '
                        </ul>
                    </nav>';
            }
        ?>

        <div class="relatos-area">
        <?php 
            if ($_SESSION['tipo_usuario'] == 4) {
                echo "
                <div class='card-cria-relato'>
                        <div class='foto-perfil'>
                            <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
                        </div>
    
                        <form onsubmit='enviarRelato(event)' class='campo-texo' method='post'>
                            <textarea name='conteudo-relato' id='' cols='100' rows='3' style='resize: none;' placeholder='Digite aqui seu relato...' value=";
                                if (isset($_SESSION['conteudo-relato'])) {
                                    echo $_SESSION['conteudo-relato'];
                                    unset($_SESSION['conteudo-relato']);
                                } else {
                                    echo '';
                                }
                            echo "
                            ></textarea>
                            <div class='parte-inferior'>
                                <div class='escolhas-relato'>
                                    <ul>
                                        <li id='icone-vicios'> 
                                            <a href='#'> 
                                                <img src='../img/iconeCriaRelato/iconeVicios.png' alt=''> 
                                                <p>Vicíos</p>
                                            </a> 
    
                                            <div class='card-escolha-relato escolha-vicios esconde'>
                                                <ul>";
                                                    
                                                    $ViciosnNoIcone = selectFromDb(
                                                        conn: $conn,
                                                        atributos: "*",
                                                        tabela: "tb_vicios"
                                                    );
    
                                                    if ($itensVicio) {
                                                        while ($row = mysqli_fetch_assoc($ViciosnNoIcone)) {
                                                            echo "
                                                            <li>
                                                                <input type='checkbox' name='vicios-selecionados[]' id='{$row['descricao_vicio']}' value='{$row['cod_vicio']}'> <label for='{$row['descricao_vicio']}'>{$row['descricao_vicio']}</label>
                                                            </li>";
                                                        };
                                                    }
                                                echo "
                                                </ul>
                                            </div>
                                        </li>
    
                                        <li id='icone-identificacoes'>   
                                            <a href='#'> 
                                                <img src='../img/iconeCriaRelato/iconeIdentificacao.png' alt=''>
                                                <p>Identificação</p>
                                            </a> 
    
                                            <div class='card-escolha-relato escolha-identificacoes esconde'>
                                                <ul>";
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
                                                echo "
                                                </ul>
                                            </div>
                                        </li>
    
                                        <li id='icone-anonimo'> 
                                            <a href='#'> 
                                                <label for='anonimo-check'>
                                                    <img src='../img/iconeCriaRelato/iconeAnonimo.png' alt=''>
                                                    <p>Anônimo</p>
                                                </label>
                                                <input type='checkbox' name='esta-anonimo' id='anonimo-check'>
                                            </a> 
                                        </li>
                                    </ul>
                                </div>
    
                                <button type='submit' class='btn-publicar'>
                                    Publicar
                                </button>
                            </div>
                        </form>
                </div>";
            }
        
        ?>

            <?php 
                $resultado =selectFromDb( 
                    conn: $conn,
                    atributos: '
                        u.nome_usuario,
                        r.cod_relato,
                        r.conteudo_relato,
                        r.esta_anonimo,
                        CAST(r.data_hora_envio AS DATE) as data_envio,
                        SUM(
                            CASE
                                WHEN  r.cod_relato = rc.cod_relato THEN 1
                                ELSE 0
                            END
                        ) AS upvotes,
                        ir.descricao_identificacao,
                        c.nome_cidade
                    ',
                    tabela: '
                        tb_relatos r, 
                        tb_usuarios u, 
                        tb_identificacoes_relato ir, 
                        tb_relato_curtidas rc,
                        tb_cidades c
                    ',
                    condicao: '
                    u.cod_usuario = r.cod_usuario_relato AND 
                    r.cod_status_relato = 3 AND 
                    r.cod_identificacao_relato = ir.cod_identificacao_relato AND
                    c.cod_cidade = u.cod_cidade
                    ',
                    grupo: '
                        u.nome_usuario,
                        r.conteudo_relato,
                        ir.descricao_identificacao,
                        r.esta_anonimo
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
                                            <p>{$row['descricao_identificacao']}</p>
                                        </div>
                                    </div>";
                                    
                                    $viciosDB = selectFromDb(
                                        conn: $conn,
                                        atributos: '
                                              tv.descricao_vicio,
                                              tv.cod_vicio
                                          ',
                                        tabela: '
                                              tb_relato_vicios trv,
                                              tb_vicios tv
                                          ',
                                        condicao: "
                                              trv.cod_vicio = tv.cod_vicio and 
                                              trv.cod_relato = {$row['cod_relato']};
                                          "
                                      );

                                    echo "<div class='downtext'>
                                        <div class='sobre-vicios'>";
                                        while($rowVicios = mysqli_fetch_assoc($viciosDB)) {
                                            echo "<p id='{$rowVicios['cod_vicio']}' >{$rowVicios['descricao_vicio']}</p>";
                                        }
                                        echo "</div>
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

                                <div class='footer-relato'>";
                                if ($_SESSION['tipo_usuario'] == 4) {
                                    echo "
                                    <div class='upvote-area'>
                                        <p> {$row['upvotes']} </p>
                                        <a href='?cod_relato_curtido={$row['cod_relato']}' class='upvote'>
                                            <div class='upvote-interno ";  
                                                $marcaRelatosCurtidos = selectFromDb(conn: $conn, atributos: '*', tabela: 'tb_relato_curtidas');
                                            
                                                if ($marcaRelatosCurtidos) {
                                                    while ($rowUpVoteMarcado = mysqli_fetch_assoc($marcaRelatosCurtidos)) {
                                                        if ($_SESSION['cod_usuario'] == $rowUpVoteMarcado['cod_usuario'] && $row['cod_relato'] == $rowUpVoteMarcado['cod_relato']) {
                                                            echo "upvote_marcado";
                                                        }
                                                        else {
                                                            echo '';
                                                        }
                                                    }
                                                };
                                            echo "'></div>
                                        </a>
                                    </div>";
                                }
                                echo "    
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
        
        <!-- Curtir Relato -->
        <?php 
            if (isset($_GET['cod_relato_curtido'])) {
                $relatosCurtidos = selectFromDb(conn: $conn, atributos: "*", tabela: "tb_relato_curtidas");

                if ($relatosCurtidos) {
                    while ($rowCurtidos = mysqli_fetch_assoc($relatosCurtidos)) {
                        
                        if ($_SESSION['cod_usuario'] == $rowCurtidos['cod_usuario'] && $_GET['cod_relato_curtido'] == $rowCurtidos['cod_relato']) {
                            deleteDb(conn: $conn, tabela: 'tb_relato_curtidas', campo: 'cod_relato', id: "{$_GET['cod_relato_curtido']} AND cod_usuario = {$_SESSION['cod_usuario']}" );
                            echo "<script> window.location = './relatos.php' </script>";
                            return;
                        } 
                    }

                    insertIntoDb(conn: $conn, tabela: 'tb_relato_curtidas', valores: "{$_SESSION['cod_usuario']}, {$_GET['cod_relato_curtido']}");
                    echo "<script> window.location = './relatos.php' </script>";
                    return;
                }
            }
        ?>

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

            const filtroID = "<?php if (isset($_GET['idFiltro'])) {
                echo $_GET['idFiltro'];
            } ?>"
            const relatoList = document.querySelectorAll('.card-relato')
            relatoList.forEach( (relato, index) => {
                const relatoTagList = []
                for (const tag of relato.querySelector('.sobre-vicios').childNodes) {
                    if ( filtroID == 0 ) {
                        relatoTagList.push('tem')
                        break
                    }
                    else if (tag.id == filtroID) {
                        relatoTagList.push(tag.id)
                    }
                }                
                if (relatoTagList.length === 0) {
                    relato.style.display = 'none'
                }
                
            })
    </script>

</body>
</html>