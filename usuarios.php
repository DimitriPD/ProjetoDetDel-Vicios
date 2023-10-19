<?php
    include('./components.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<body>
    <?php echo $header?>
    

    <main>
        <div class="usuarios-area">
            <?php
                $codUsuarioAnterior = selectFromDb($conn, 'cod_usuario', 'tb_usuarios', null, 'cod_usuario desc');
                
                if ($codUsuarioAnterior) {
                    while ($row = mysqli_fetch_assoc($codUsuarioAnterior)) {
                        echo $row['cod_usuario'];
                    }
                }

                // $selectUsuarios = selectFromDb(
                //     $conn, //Conexao
                //     // Inicio Atributos
                //     'u.cod_usuario as Código,  
                //     u.nome_usuario as Usuário,  
                //     u.email as `E-mail`, u.senha_hash as Senha, 
                //     u.data_nascimento as `Data de Nascimento`, 
                //     c.nome_cidade as Cidade,
                //     e.nome_estado as Estado',
                //     // Fim Atributos
                //     // Tabela(s)
                //     'tb_usuarios u, tb_cidades c, tb_estados e',
                //     // Condicao
                //     '(u.cod_cidade = c.cod_cidade AND c.cod_estado = e.cod_estado)',
                //     // Ordenacao
                //     '(Código)'
                // );

                // if ($selectUsuarios) {
                //     while($row = mysqli_fetch_assoc($selectUsuarios)) {
                //         echo "<div class='card-usuario'>";
                //             foreach ($row as $key => $value) {
                //                 echo " 
                //                     <div class='card-usuario-item'>
                //                         <p>$key: $value</p>
                //                     </div> 
                //                 ";
                //             };

                //             echo '<div class="btn-usuarios-area">
                //                 <button class="btn-usuarios">Editar</button>
                //                 <button class="btn-usuarios">Excluir</button>
                //             </div>';
                //         echo "</div>";
                //     }
            
                // } else {
                //     return 'Nenhum registro encontrado';
                // };
            ?>
        </div> 
    </main>
</body>
</html>