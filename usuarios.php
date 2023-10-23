<?php
    session_start();
    include('./components.php');
    
?>

<!DOCTYPE html>
<html lang="pt-BR">
<body >
    <?php
        if (!isset($_SESSION['id']) && !isset($_SESSION['tipo_usuario'])) {
            $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
            header('Location: ./index.php');
            return;
        }

        if ($_SESSION['tipo_usuario'] > 2) {
            $_SESSION['msg-bloqueante'] = '<h1 class="session-error"> Sem autorização para acessar essa página! </h1>';
            header('Location: ./home.php');
            return;
        }

        createHeader(["home", "relatos","usuarios", "sair"]);
    ?>
    

    <main class="container">
        <div class="usuarios-area">
            <?php
                // Faz um select from no Banco
                $res = selectFromDb(
                    $conn, //Conexao
                    // Inicio Atributos
                    'u.cod_usuario as Código,  
                    u.nome_usuario as Usuário,  
                    u.email as `E-mail`, u.senha_hash as Senha, 
                    u.data_nascimento as `Data de Nascimento`, 
                    u.data_hora_cadastro as `Hora Cadastro`,
                    c.nome_cidade as Cidade,
                    e.nome_estado as Estado',
                    // Fim Atributos

                    // Tabela(s)
                    'tb_usuarios u, tb_cidades c, tb_estados e',
                    // Where
                    '(u.cod_cidade = c.cod_cidade AND c.cod_estado = e.cod_estado)',
                    null,
                    // Order By
                    '(Código)'
                );
                
                // Se tiver registro no Banco
                if ($res) {
                    // Até a ultima linha
                    while($row = mysqli_fetch_assoc($res)) {
                        echo "<div class='card-usuario'>";
                            
                            // Pegar cada retornado $value = atributo usuado na funcao selectFromDb
                            foreach ($row as $key => $value) {
                                echo " 
                                    <div class='card-usuario-item'>
                                        <p>$key: $value</p>
                                    </div> 
                                ";
                            };

                            echo "<div class='btn-usuarios-area'>
                                <a href='#' class='btn-usuarios'>Editar</a >
                                <a href='?cod_usuario={$row['Código']}&usuario={$row['Usuário']}&esconde='' class='btn-usuarios'>Excluir</a >
                            </div>";
                        echo "</div>";
                    }
                } else {
                    return 'Nenhum registro encontrado';
                };
            ?>
        </div> 

        <div class="confirma-deletar-area <?php if(isset($_GET['esconde'])) {echo $_GET['esconde'];} else {echo 'escondido';} ?>">
            <div class="confirma-deletar">
                <p>Deseja excluir usuário: <?= $_GET['usuario']?>?</p>
                <div class='btn-usuarios-area'>
                    <a href='?clicou=sim&cod=<?= $_GET['cod_usuario']?>' class='btn-usuarios'>Sim</a >
                    <a href='#' class='btn-usuarios' onclick='window.location = "./usuarios.php"'>Não</a >
                </div>
            </div>
        </div>
    </main>

    <?php
        if (isset($_GET['clicou'])) {
            // Deletar Usuário
            if (isset($_GET['cod'])) {
                $cod = $_GET['cod'];
                deleteDb($conn, 'tb_usuarios', 'cod_usuario', $cod);
                echo "<script> window.location = './usuarios.php' </script>";
            }
        }
    ?>

</body>
</html>