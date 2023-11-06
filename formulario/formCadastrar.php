<?php 
    session_start();
    include_once(__DIR__ . "/../functions/index.php");
?>
 
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icones/detdelunity.jpeg" type="image/x-icon">

    <link rel="stylesheet" href="./formulario.css">
    <link rel="stylesheet" href="../style.css">
    <script src="./formulario.js" defer></script>

    <title>Projeto DetDelDel</title>
</head>

<body>
    <?php    
        $dados = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($dados)) {
            $_SESSION['dadosCadastrar'] = $dados;
            // var_dump($dados);
            // Caso o email já esteja registrado no banco redireciona para a página de cadastro, com a msg "Email já registrado."
            if (selectFromDb($conn, 'email', 'tb_usuarios', "email = '{$dados['email']}'")) {
                $_SESSION['msg-email-ja-cadastrado'] = "Esse email já está sendo usado.";
                header('Location: ./formCadastrar.php');
                return;
            } else {
                // Pega o horário atual levando em conta o fuso horário de são paulo
                date_default_timezone_set('America/Sao_Paulo');
                $hora_cadastro = date("Y-m-d H:i:s");

                // Auto increment em código, só para não ter que alterar o banco
                $codUsuarioAnterior = selectFromDb($conn, 'cod_usuario', 'tb_usuarios', null, 'cod_usuario desc', 1);
                if ($codUsuarioAnterior) {
                    while ($row = mysqli_fetch_assoc($codUsuarioAnterior)) {
                        settype($row['cod_usuario'],'integer');
                        $id = $row['cod_usuario'] + 1;
                    }
                }

                // Formata a data para o modelo que o banco aceita Ano/Mes/Dia
                $data_nasc = explode('-', $dados['data_nascimento']);
                $data_nasc_formatada= "$data_nasc[2]-$data_nasc[1]-$data_nasc[0]";

                $tipo_usuario = 4;

                // Valores para comando SQL 
                $data = "$id, '{$dados['nome_usuario']}', '{$dados['email']}', '{$dados['senha']}', '$data_nasc_formatada', '$hora_cadastro', {$dados['seleciona-cidade']}, $tipo_usuario";

                $_SESSION['succes-cadastro'] = 'Cadastro realizado com sucesso!';
                // Faz um insert into no banco
                insertIntoDb($conn, 'tb_usuarios', $data);   
                // Redireciona para página descrita
                header('Location: ../index.php');
            }
        }
    ?>    
    <div class="container-form">
        <div class='logo-header'>
            <div class='texto-simbolo'>
                <div class=simbolo>
                    <img src='../img/logo/simbolo-index.png' alt=''>
                </div>
                <div class='texto texto-index'>
                    <p>Vícios E</p>
                    <p>Vivências</p>
                </div>
            </div>
            <div class='rosto'>
                <img src='../img/logo/rosto-index.png' alt=''>
            </div>
        </div>
        
        <div class="form-area" >
            <form class='form ' id="form-cadastra" action="" method="POST" autocomplete="off" >
                <div class="form-item">
                    <input type="text" name="nome_usuario" id="id_nome_usuario_cadastrar" required placeholder="Nome usuário" value=<?php
                        if (isset($_SESSION['dadosCadastrar']['nome_usuario'])) {
                            echo $_SESSION['dadosCadastrar']['nome_usuario'];
                            unset($_SESSION['dadosCadastrar']['nome_usuario']);
                        } else {
                            echo '';
                        }
                    ?>>
                </div>
                <div class="form-item aviso-email">
                    <input type="text" name="email" id="id_email" oninput="mostraAvisoEmail(this)" required placeholder="Email" value=<?php
                    // Mantem o que ja foi digitado
                        if (isset($_SESSION['dadosCadastrar']['email'])) {
                            echo $_SESSION['dadosCadastrar']['email'];
                            unset($_SESSION['dadosCadastrar']['email']);
                        } else {
                            echo '';
                        }
                    ?>>
                    <?php
                    // Apareca a msg de email ja cadastrado
                        if (isset($_SESSION['msg-email-ja-cadastrado'])) {
                            echo "<span class='aviso-erro-session'> {$_SESSION['msg-email-ja-cadastrado']} </span>";
                            unset($_SESSION['msg-email-ja-cadastrado']);
                        }
                    ?>
                </div>
                <div class="form-item aviso-senha">
                    <input type="password" name="senha" id="id_senha_cadastrar" oninput="mostraAvisoSenha(this)" class="esconde-senha" required placeholder="Senha" value=<?php
                    // Mantem o que ja foi digitado
                        if (isset($_SESSION['dadosCadastrar']['senha'])) {
                            echo $_SESSION['dadosCadastrar']['senha'];
                            unset($_SESSION['dadosCadastrar']['senha']);
                        } else {
                            echo '';
                        }
                    ?>>
                </div>
                <div class="form-item">
                    <div class='btn-mostra-senha' id='btn-form-cadastrar' tabindex="0" onclick='mostraSenha("id_senha_cadastrar", id)'>Mostrar</div>
                </div>
                <div class="form-item ">
                    <div class="item_duplo aviso-data">
                        <input type="text" name="data_nascimento" id="id_data_nascimento" oninput="mascaraNasc(this, event), mostraAvisoDataNasc(this)" required placeholder="Data de nascimento" value=<?php
                    // Mantem o que ja foi digitado
                        if (isset($_SESSION['dadosCadastrar']['data_nascimento'])) {
                            echo $_SESSION['dadosCadastrar']['data_nascimento'];
                            unset($_SESSION['dadosCadastrar']['data_nascimento']);
                        } else {
                            echo '';
                        }
                    ?>>
                    </div>
                    <div class="item_duplo aviso-cidade">
                        <?php
                            // Puxa do Banco as cidades cadastradas
                            $selectCidades = selectFromDb($conn, 'cod_cidade, nome_cidade', 'tb_cidades', null, 'cod_cidade desc');
                            if ($selectCidades) {
                                echo '
                                    <select name="seleciona-cidade" class="form-select" id="id_seleciona-cidade">
                                    <option value="" disabled selected hidden> Cidade </option>
                                ';      // Cria um opcao com cada cidade que foi puxada do banco
                                        while ($row = mysqli_fetch_assoc($selectCidades)) {
                                            echo " <option name='teste' class='op_select'  value='{$row['cod_cidade']}'>  {$row['nome_cidade']}  </option>";
                                        };
                                        echo '</select>';
                            };
                        ?>
                    </div>
                </div>
                <div class="form-item form-submit">
                    <button type="submit" name="submit" value='Enviar'>Enviar</button>
                </div>

                <div class="separa-form">
                    <section class="muda-form">
                        <a href="../index.php"> Voltar ao login </a>
                    </section>
                </div>
            </form>
            
        </div>
    </div>

</body>
</html>