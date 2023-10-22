<?php 
    session_start();
    include_once("./components.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<body>
    <?php 
        $dados = filter_input_array (INPUT_POST, FILTER_DEFAULT);

        if (!empty($dados)) {
            // var_dump($dados);
            // Caso o email já esteja registrado no banco redireciona para a página de cadastro, com a msg "Email já registrado."
            if (selectFromDb($conn, 'email', 'tb_usuarios', "email = '{$dados['email']}'")) {
                $_SESSION['msg-email-ja-cadastrado'] = "Email já registrado.";
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

                $_SESSION['succes-cadastro'] = 'Cadastro Realizado Com Sucesso!';
                // Faz um insert into no banco
                insertIntoDb($conn, 'tb_usuarios', $data);   
                // Redireciona para página descrita
                header('Location: ./index.php');
            }
        }
    ?>    
    
    <div class="form-area">
        <section class='form-header'>
            <h1>Cadastrar-se</h1>
        </section>
        <form class='form ' id="form-cadastra" action="" method="POST" autocomplete="off">
            <div class="form-item">
                <label for="id_nome_usuario_cadastrar">Nome: </label>
                <input type="text" name="nome_usuario" id="id_nome_usuario_cadastrar" required>
            </div>
            <div class="form-item aviso-email">
                <label for="id_email">Email: </label>
                <input type="text" name="email" id="id_email" required>
                <?php
                if (isset($_SESSION['msg-email-ja-cadastrado'])) {
                    echo "<span class='msg-session'> {$_SESSION['msg-email-ja-cadastrado']} </span>";
                    unset($_SESSION['msg-email-ja-cadastrado']);
                }
                    
                ?>
            </div>
            <div class="form-item aviso-senha">
                <label for="id_senha_cadastrar">Senha: </label>
                <input type="password" name="senha" id="id_senha_cadastrar" class="esconde-senha" required>
            </div>

            <div class="form-item">
                <div class='btn-mostra-senha' id='btn-form-cadastrar' tabindex="0" onclick='mostraSenha("id_senha_cadastrar", id)'>Mostrar</div>
            </div>

            <div class="form-item aviso-data">
                <div class="item_duplo ">
                    <label for="id_data_nascimento">Data de Nascimento: </label>
                    <input type="text" name="data_nascimento" id="id_data_nascimento" oninput="mascaraNasc(this, event)" required>
                </div>

                <div class="item_duplo">
                    <?php
                        // Puxa do Banco as cidades cadastradas
                        $selectCidades = selectFromDb($conn, 'cod_cidade, nome_cidade', 'tb_cidades', null, 'cod_cidade desc');
                        if ($selectCidades) {
                            echo '
                                <label for="id_seleciona-cidade">Cidade: </label>
                                <select name="seleciona-cidade" class="form-select" id="id_seleciona-cidade">
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
        </form>

        <section class="muda-form">
            <a href="./index.php"> Entrar </a>
        </section>
    </div>
    <script src="./js/formulario.js"></script>

</body>
</html>