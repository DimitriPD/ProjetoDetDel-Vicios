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
  <link rel="stylesheet" href="./meuPerfil.css">
  <title>Projeto DetDelDel</title>
</head>

<body>
  <?php
  if (!isset($_SESSION['id'])) {
    $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
    header('Location: ../index.php');
  }
  ?>

  <main class='container'>
    <?php
    createHeader($_SESSION['tipo_usuario'], $_SESSION['nome_usuario']);
    ?>
    <div class='perfil-area'>
      <div class='card-dados-perfil'>
        <div class='foto-perfil'>
          <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
        </div>
        <div class='dados-pessoais'>
          <div class='descricao'>

            <?php
            $codUsuario = $_SESSION['cod_usuario'];
            $resultadoUsuario = selectFromDb(
              conn: $conn,
              atributos: '
                  u.nome_usuario,
                  u.email,
                  u.data_nascimento,
                  c.nome_cidade
              ',
              tabela: '
                  tb_usuarios u,
                  tb_cidades c
              ',
              condicao: "
                  u.cod_cidade = c.cod_cidade and
                  u.cod_usuario = $codUsuario
              ",
              grupo: null,
              ordena: null
            );

            if ($resultadoUsuario) {
              $usuario = mysqli_fetch_assoc($resultadoUsuario);
              echo "
                  <p>Nome:  {$usuario['nome_usuario']}</p>
                  <p>Email:  {$usuario['email']}</p>
                  <p>Data de Nascimento:  {$usuario['data_nascimento']}</p>
                  <p>Cidade:  {$usuario['nome_cidade']}</p>
                ";
            }
            ?>
          </div>
          <div class='editar'>
            <a href="#" class='btn-editar'>
              Editar
            </a>
          </div>
        </div>
      </div>

      <div class='relatos-pergutas-area'>

        <div class='opcao'>

        </div>
        <?php
        $codUsuario = $_SESSION['cod_usuario'];
        $relatos = selectFromDb(
          conn: $conn,
          atributos: '
              u.nome_usuario,
              r.conteudo_relato,
              r.esta_anonimo,
              r.cod_relato,
              trs.descricao_status_relato ,
              CAST(r.data_hora_envio AS DATE) as data_envio,
              r.data_hora_analise,
              descricao_analise,
              ir.descricao_identificacao,
              c.nome_cidade
          ',
          tabela: '
              tb_relatos r, 
              tb_usuarios u, 
              tb_identificacoes_relato ir, 
              tb_cidades c,
              tb_relato_status trs 
          ',
          condicao: "
              (r.cod_usuario_relato = $codUsuario and 
              u.cod_usuario = r.cod_usuario_relato AND 
              r.cod_identificacao_relato = ir.cod_identificacao_relato AND
              c.cod_cidade = u.cod_cidade and 
              trs.cod_status_relato = r.cod_status_relato)
          ",
          grupo: null,
          ordena: 'r.data_hora_envio desc'
        );

        if ($relatos) {
          while ($rowRelato = mysqli_fetch_assoc($relatos)) {
            echo "
            <div class='card-relato'>
                <div class='foto-perfil-relato'>
                    <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCu9WdinxWc7EOwkm-nBtKcoAfX3OwWi_Z-yfAgHo&s' alt='f'>
                </div>
                <div class='header-relato'>
                  <div class='uptext'>
                  <p>";
            if ($rowRelato['esta_anonimo'] == 1) {
              echo "Anônimo";
            } else {
              echo $rowRelato['nome_usuario'];
            }
            echo "</p>

                  <div class='identificacao-relato'>
                      <p>{$rowRelato['descricao_identificacao']}</p>
                  </div>
              </div>";

            $vicios = selectFromDb(
              conn: $conn,
              atributos: '
                    tv.descricao_vicio 
                ',
              tabela: '
                    tb_relato_vicios trv,
                    tb_vicios tv
                ',
              condicao: "
                    trv.cod_vicio = tv.cod_vicio and 
                    trv.cod_relato = {$rowRelato['cod_relato']};
                ",
              grupo: null,
              ordena: null
            );


            echo "<div class='downtext'>
               <div class='sobre-vicios'>";
            while ($rowVicios = mysqli_fetch_assoc($vicios)) {
              echo "<p>{$rowVicios['descricao_vicio']}</p>";
            }
            echo "
            </div>
              </div>
                </div>
                  <div class='conteudo-relato'>
                    <div class='conteudo'>
                        {$rowRelato['conteudo_relato']}
                    </div>

                    <div class='data-cidade-relato'>
                        <p>{$rowRelato['nome_cidade']}</p>
                        <p>{$rowRelato['data_envio']}</p>
                    </div>
                </div>

        <div class='footer-relato'>
            <div class='status-relato'>
                <div class='status-relato-icon'>
                    <img src='../img/iconesStatus/{$rowRelato['descricao_status_relato']}.png' alt='F'>
                </div>
                {$rowRelato['descricao_status_relato']}
            </div>
            <div class='relato-botoes'>";

            if ($rowRelato['descricao_status_relato'] == 'EM ANÁLISE') {
              echo "
                <a href='#' class='relato-botoes-editar'>
                    Editar
                </a>
                ";
            }
            echo "
                <a href='#' class='relato-botoes-excluir'>
                    Excluir
                </a>
            </div>
        </div>
        </div>";
          }
        } else {
          echo '<div> 
                    <h1> Você não enviou nenhum relato! </h1>
                </div>';
        }
        ?>
      </div>
    </div>

  </main>
</body>

</html>