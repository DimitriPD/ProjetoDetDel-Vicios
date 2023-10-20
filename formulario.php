<?php 
    include_once('./components.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<body onload="mudaFormText()">
    <?php echo $header?>

    <div class="form-area">
        <section class='form-header esconde-form'>
            <h1>Entrar</h1>
        </section>

        <form class="form esconde-form" action="./usuarios.php" method="post" autocomplete="off">
            <div class="form-item">
                <label for="id_nome_usuario_entrar">Usuario: </label>
                <input type="text" name="nome_usuario" id="id_nome_usuario_entrar" required>
            </div>

            <div class="form-item">
                <label for="id_senha_entrar">Senha: </label>
                <input type="password" name="senha" id="id_senha_entrar" required>
            </div>

            <div class="form-item">
                <div class='btn-mostra-senha' id='btn-form-entrar' tabindex="0" onclick='mostraSenha("id_senha_entrar", id)'>Mostrar</div>
            </div>

            <div class="form-item form-submit">
                <button type="submit" name="submit">Enviar</button>
            </div>
        </form>
        <!-- -------------------------------------------------------------------------------------------------- -->
        <section class='form-header '>
            <h1>Cadastrar-se</h1>
        </section>
        <form class='form ' id="form-cadastra" action="./usuarios.php" method="post" autocomplete="off">
            <div class="form-item">
                <label for="id_nome_usuario_cadastrar">Usuario: </label>
                <input type="text" name="nome_usuario" id="id_nome_usuario_cadastrar" required>
            </div>
            <div class="form-item aviso-email">
                <label for="id_email">Email: </label>
                <input type="text" name="email" id="id_email" required>
            </div>
            <div class="form-item aviso-senha">
                <label for="id_senha_cadastrar">Senha: </label>
                <input type="password" name="senha" id="id_senha_cadastrar" class="esconde-senha" required>
            </div>

            <div class="form-item">
                <div class='btn-mostra-senha' id='btn-form-cadastrar' tabindex="0" onclick='mostraSenha("id_senha_cadastrar", id)'>Mostrar</div>
            </div>

            <div class="form-item">
                <div class="item_duplo">
                    <label for="id_data_nascimento">Data de Nascimento: </label>
                    <input type="text" name="data_nascimento" id="id_data_nascimento" required>
                </div>

                <div class="item_duplo">
                    <?php
                        $selectCidades = selectFromDb($conn, 'cod_cidade, nome_cidade', 'tb_cidades', null, 'cod_cidade desc');
                        if ($selectCidades) {
                            echo '
                                <label for="id_seleciona-cidade">Cidade: </label>
                                <select name="seleciona-cidade" class="form-select" id="id_seleciona-cidade">
                            ';
                                    while ($row = mysqli_fetch_assoc($selectCidades)) {
                                        echo " <option name='teste' class='op_select'  value='{$row['cod_cidade']}'>  {$row['nome_cidade']}  </option>";
                                    };
                                    echo '</select>';
                        };
                    ?>
                </div>
            </div>

            <div class="form-item form-submit">
                <button type="submit" name="submit">Enviar</button>
            </div>
        </form>

        <section class="muda-form">
            <a href="#" class="btn-muda-form" onclick="mudaForm()"> Cadastrar-se </a>
        </section>


    </div>

    <script src="./js/formulario.js" defer></script>
</body>

</html>