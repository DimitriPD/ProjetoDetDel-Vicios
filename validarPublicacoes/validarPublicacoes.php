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
    <link rel="stylesheet" href="../relatos/relatos.css">
    <link rel="stylesheet" href="./validaPubli.css">

    <script src="../utils/tags.js" defer></script>

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
        <?php createHeader($_SESSION['tipo_usuario'], $_SESSION['nome_usuario'])?>
        
        <div class="relatos-area">
            <h1>Relatos Para Analise</h1> <br> <br>  <!-- Só para não ter que alterar o CSS dos relatos -->
            <?php 
                $resultado =selectFromDb( 
                    conn: $conn,
                    atributos: '
                        u.nome_usuario,
                        r.cod_relato,
                        r.conteudo_relato,
                        r.esta_anonimo,
                        CAST(r.data_hora_envio AS DATE) as data_envio,
                        ir.descricao_identificacao,
                        c.nome_cidade
                    ',
                    tabela: '
                        tb_relatos r, 
                        tb_usuarios u, 
                        tb_identificacoes_relato ir, 
                        tb_cidades c
                    ',
                    condicao: '
                    u.cod_usuario = r.cod_usuario_relato AND 
                    r.cod_status_relato = 1 AND 
                    r.cod_identificacao_relato = ir.cod_identificacao_relato AND
                    c.cod_cidade = u.cod_cidade
                    ',
                    grupo: '
                        u.nome_usuario,
                        r.conteudo_relato,
                        ir.descricao_identificacao,
                        r.esta_anonimo
                    ',
                    ordena: 'data_envio asc'
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
                                echo "
                                    <div class='downtext'>
                                        <div class='sobre-vicios'>";
                                        while ($rowVicios = mysqli_fetch_assoc($viciosDB)) {
                                            echo " <p id='{$rowVicios['cod_vicio']}'>{$rowVicios['descricao_vicio']}</p>";
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
                                $acaoAprovar = 'aprovar';
                                $acaoReprovar = 'reprovar';
                                echo "
                                    <div class='btn-area'>
                                        <a class='btn-reprovar' href='?codRelato={$row['cod_relato']}&acao=$acaoReprovar'>Reprovar</a>
                                        <a class='btn-aprovar'href='?codRelato={$row['cod_relato']}&acao=$acaoAprovar'>Aprovar</a>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo '<div> 
                        <h2> Nenhuma publicação pendende para analise! </h2>    
                    </div>';
                }
            ?>
        </div>

        <?php 
            if (isset($_GET['codRelato'])) {
                $conteudo = selectFromDb(conn: $conn, atributos: 'conteudo_relato', tabela: "tb_relatos", condicao: "cod_relato = {$_GET['codRelato']}");
            
                if ($conteudo) {
                    $cont = mysqli_fetch_assoc($conteudo);
                    
                    echo "
                        <div class='edicao-relato-area'> 
                            <form action='./validarPublicacoes.php' method='post' id='formAdmValida' autocomplete='off'>";
                                if (isset($_GET["acao"]) && $_GET["acao"] == 'reprovar') {
                                    echo "
                                    <div class='conteudo-relato'>
                                        {$cont['conteudo_relato']} 
                                    </div>
                                    <input type='hidden' name='cod-relato-reprovar' id='' value='{$_GET['codRelato']}'>
                                    <input type='text' name='justificativa_relato' id='justificativa_relato' placeholder='Justificativa...'>
                                    <div class='btn-area'>
                                        <a href='./validarPublicacoes.php' class='btn-cancelar'>Cancelar</a>
                                        <button type='submit'>Enviar</button>
                                    </div>
                                    ";
                                }

                                if (isset($_GET["acao"]) && $_GET["acao"] == 'aprovar') {
                                    echo "
                                    <div class='conteudo-relato'>
                                        {$cont['conteudo_relato']} 
                                    </div>
                                    <input type='hidden' name='cod-relato-aprovar' id='' value='{$_GET['codRelato']}'>
                                    <div class='btn-area'>
                                        <p> Deseja aprovar essa publicação: </p>
                                        <a href='./validarPublicacoes.php' class='btn-cancelar'>Não</a>
                                        <button type='submit'>Sim</button>
                                    </div>
                                    ";
                                }
                            echo "
                            </form>
                        </div>";
                };
            }
            
            if (isset($_POST['cod-relato-reprovar'])) {

                date_default_timezone_set('America/Sao_Paulo');
                $data_hora_analise = date("Y-m-d H:i:s");

                $dados = array(
                    'cod_status_relato' => '2',
                    'cod_usuario_analise' => $_SESSION['cod_usuario'],
                    'data_hora_analise' => $data_hora_analise,
                    'descricao_analise' => $_POST['justificativa_relato']
                );
                
                updateInDb(conn: $conn, tabela: 'tb_relatos', dados: $dados, condicao: "cod_relato = {$_POST['cod-relato-reprovar']}");
                echo "<script> window.location = './validarPublicacoes.php' </script>";
            }

            if (isset($_POST["cod-relato-aprovar"])) {
                date_default_timezone_set('America/Sao_Paulo');
                $data_hora_analise = date("Y-m-d H:i:s");

                $dados = array(
                    'cod_status_relato' => '3',
                    'cod_usuario_analise' => $_SESSION['cod_usuario'],
                    'data_hora_analise' => $data_hora_analise
                );

                updateInDb(conn: $conn, tabela: 'tb_relatos', dados: $dados, condicao: "cod_relato = {$_POST['cod-relato-aprovar']}");
                echo "<script> window.location = './validarPublicacoes.php' </script>";
            }

        ?>
    </main>

    <script>
        document.querySelector("#formAdmValida").addEventListener('submit', (event) => {
            const justificativa = document.querySelector('#justificativa_relato').value
            if (justificativa.trim() === '' || justificativa.length < 20) {
                event.preventDefault()
                alert("Justificativa deve conter pelo menos 20 caracteres!")
                return
            }
        })
    </script>
</body>
</html>