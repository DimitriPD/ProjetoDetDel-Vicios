<?php 
    session_start();
    ob_start();
    include_once(__DIR__ . '/functions/index.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="stylesheet" href="./formulario/formulario.css" >
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php
        if (isset($_SESSION['id'])) {
            header('Location: ./relatos/relatos.php');
        }
    
        $dados = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($dados)) {
            $res = selectFromDb(
                $conn, 
                '
                u.email,
                u.senha_hash as senha,
                u.cod_tipo_usuario 
                ',
                'tb_usuarios u',
                "(u.email = '{$dados['email']}' AND u.senha_hash = '{$dados['senha']}')"
            );

            if ($res) {
                if ($row = mysqli_fetch_assoc($res)) {
                    $_SESSION['id'] = session_id();
                    $_SESSION['cod_usuario'] = $row['cod_usuario'];
                    $_SESSION['tipo_usuario'] = $row['cod_tipo_usuario'];

                    header('Location: ./relatos/relatos.php');
                };
            } else {
                $_SESSION['msg-login-erro'] = 'Email ou Senha inválido!';
                header('Location: ./index.php');
                return;
            };
            
        }
    ?>
    
    <div> 
        <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            if (isset($_SESSION['msg-login-erro'])) {
                echo "<h1 class='session-error'> {$_SESSION['msg-login-erro']} </h1>";
                unset($_SESSION['msg-login-erro']);
            };
            if (isset( $_SESSION['succes-cadastro'])) {
                echo "<h1 class='session-success'> {$_SESSION['succes-cadastro']} </h1>";
                unset($_SESSION['succes-cadastro']);
            };
        ?>    
    </div>
    
    <div class="form-area">
        <!-- classe 'esconde-form' define o display como none -->
        <section class='form-header '>
            <h1>Entrar</h1>
        </section>
        
        <form class="form " action="" method="POST" autocomplete="off">
            <div class="form-item">
                <label for="id_nome_usuario_entrar">Email: </label>
                <input type="text" name="email"  required>
            </div>

            <div class="form-item">
                <label for="id_senha_entrar">Senha: </label>
                <input type="password" name="senha"required id="id_senha_entrar">
            </div>

            <div class="form-item">
                <div class='btn-mostra-senha' id='btn-form-entrar' tabindex="0" onclick='mostraSenha("id_senha_entrar", id)'>Mostrar</div>
            </div>

            <div class="form-item form-submit">
                <button type="submit" name="submit">Enviar</button>
            </div>
        </form>       

        <section class="muda-form">
            <a href="formulario/formCadastrar.php"> Cadastrar-se </a>
        </section>
    </div>
    
    <script>
        function mostraSenha(id_input, id_botao) {
            if (document.querySelector(`#${id_input}`).type === 'password') {
                document.querySelector(`#${id_input}`).type = 'text'
                document.querySelector(`#${id_botao}`).innerHTML = 'Esconder'
            } else {
                document.querySelector(`#${id_input}`).type = 'password'
                document.querySelector(`#${id_botao}`).innerHTML = 'Mostrar'
            }
        }

        const botoes_senha = document.querySelectorAll('.btn-mostra-senha')
        botoes_senha.forEach(botao => {
            botao.addEventListener('keyup', e => {
                if (e.key === 'Enter') {
                    e.target.click()
                }
            })
        });
    </script>
</body>

</html>