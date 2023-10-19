<?php 
    include_once('./components.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <body onload="mudaFormText()">
        <?php echo $header?>

        <div class="form-area" >
            <section class='form-header esconde-form'>
                <h1>Entrar</h1>
            </section>

            <form class="form esconde-form " action="./usuarios.php" method="post" autocomplete="off">
                <div class="form-item">
                    <label for="id_nome_usuario_entrar">Usuario: </label>
                    <input type="text" name="nome_usuario" id="id_nome_usuario_entrar">
                </div>

                <div class="form-item">
                    <label for="id_senha_entrar">Senha: </label>
                    <input type="password" name="senha" id="id_senha_entrar">
                </div>

                <div class="form-item form-submit">
                    <button type="submit" name="submit">Enviar</button>
                </div>
            </form>

            <section class='form-header  '>
                <h1>Cadastrar-se</h1>
            </section>
            <form class='form ' action="./usuarios.php" method="post" autocomplete="off">
                <div class="form-item">
                    <label for="id_nome_usuario_cadastrar">Usuario: </label>
                    <input type="text" name="nome_usuario" id="id_nome_usuario_cadastrar">
                </div>
                <div class="form-item">
                    <label for="id_email">Email: </label>
                    <input type="text" name="email" id="id_email">
                </div>
                <div class="form-item">
                    <label for="id_senha_cadastrar">Senha: </label>
                    <input type="password" name="senha" id="id_senha_cadastrar">
                </div>
                <div class="form-item">
                    <label for="id_data_nascimento">Data Nascimento: </label>
                    <input type="text" name="data_nascimento" id="id_data_nascimento">
                </div>

                <div class="form-item">

                        <?php 
                            $selectCidades = selectFromDb($conn, 'cod_cidade, nome_cidade', 'tb_cidades');
                            if ($selectCidades) {
                                echo '
                                    <label for="id_seleciona-cidade">Cidade: </label>
                                    <select name="seleciona-cidade" id="id_seleciona-cidade">
                                ';
                                        while ($row = mysqli_fetch_assoc($selectCidades)) {
                                            echo " <option name='teste'  value='{$row['cod_cidade']}'>  {$row['nome_cidade']}  </option>";
                                        };
                                        echo '</select>';
                            };
                        ?>
                </div>
                
                <div class="form-item form-submit">
                    <button type="submit" name="submit">Enviar</button>
                </div>
            </form>

            <section class="muda-form">
                <a href="#"  class="btn-muda-form" onclick="mudaForm()"> Cadastrar-se </a>
            </section>

            
        </div>


    </body>

</html>