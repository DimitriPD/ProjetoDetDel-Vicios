<?php 
    session_start();
    ob_start();
    include_once(__DIR__ . '/functions/index.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/icones/detdelunity.jpeg" type="image/x-icon">

    <link rel="stylesheet" href="./formulario/formulario.css" >
    <link rel="stylesheet" href="./style.css">

    <title>Projeto DetDelDel</title>
</head>

<body>
    <?php
        if (isset($_SESSION['id'])) {
            header('Location: ./relatos/relatos.php');
        }
    
        $dados = filter_input_array (INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($dados)) {
            $_SESSION['dadosLogin'] = $dados;
            $res = selectFromDb(
                $conn, 
                '
                u.email,
                u.senha_hash as senha,
                u.cod_tipo_usuario,
                u.nome_usuario,
                u.cod_usuario 
                ',
                'tb_usuarios u',
                "(u.email = '{$dados['email']}' AND u.senha_hash = '{$dados['senha']}')"
            );

            if ($res) {
                if ($row = mysqli_fetch_assoc($res)) {
                    if ($row["email"] !== $dados['email'] || $row["senha"] !== $dados['senha']) {
                        $_SESSION['msg-login-erro'] = 'Email ou Senha inválido!';
                        header('Location: ./index.php');
                        return;
                    }

                    $_SESSION['id'] = session_id();
                    $_SESSION['cod_usuario'] = $row['cod_usuario'];
                    $_SESSION['tipo_usuario'] = $row['cod_tipo_usuario'];
                    $_SESSION['nome_usuario'] = $row['nome_usuario'];


                    header('Location: ./relatos/relatos.php');
                };
            } else {
                $_SESSION['msg-login-erro'] = 'Email ou Senha inválido!';
                header('Location: ./index.php');
                return;
            };
            
        }
    ?>
    <div class="container-form">
        <div class='logo-header'>
            <div class='texto-simbolo'>
                <div class=simbolo>
                    <img src='./img/logo/simbolo-index.png' alt=''>
                </div>
                <div class='texto texto-index'>
                    <p>Vícios E</p>
                    <p>Vivências</p>
                </div>
            </div>
            <div class='rosto'>
                <img src='./img/logo/rosto-index.png' alt=''>
            </div>
        </div>

        <div class="form-area">
            <div class='msg-aviso'> 
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
            <form class="form " action="" method="POST" autocomplete="off">
                <div class="form-item">
                    <input type="text" name="email" required placeholder="Email" value=<?php
                        if (isset($_SESSION['dadosLogin']['email'])) {
                            echo $_SESSION['dadosLogin']['email'];
                            unset($_SESSION['dadosLogin']['email']);
                        } else {
                            echo '';
                        };
                    ?>>
                </div>
                <div class="form-item">
                    <input type="password" name="senha" required placeholder="Senha" id="id_senha_entrar" value=<?php
                        if (isset($_SESSION['dadosLogin']['senha'])) {
                            echo $_SESSION['dadosLogin']['senha'];
                            unset($_SESSION['dadosLogin']['senha']);
                        } else {
                            echo '';
                        };
                    ?>>
                </div>
                <div class="form-item">
                    <div class='btn-mostra-senha' id='btn-form-entrar' tabindex="0" onclick='mostraSenha("id_senha_entrar", id)'>Mostrar</div>
                </div>
                <div class="form-item form-submit">
                    <button type="submit" name="submit">Entrar</button>
                </div>
                <div class='separa-form'>
                    <section class="muda-form">
                        <a href="formulario/formCadastrar.php"> Criar uma conta </a>
                    </section>
                </div>
            </form>
        </div>
        
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