<?php   
    function selectFromDb (mysqli $conn, string $atributos, string $tabela, string $condicao = null, string $ordena = null, int $limita = null) {
        try {
            $sql = "SELECT $atributos FROM $tabela ";

            if ($condicao !== null) { 
                $sql .= "WHERE $condicao ";
            }

            if ($ordena !== null) {
                $sql .= "ORDER BY $ordena ";
            }

            if ($limita !== null) {
                $sql .= "LIMIT $limita ";
            }

            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows( $result );

            if ($resultCheck > 0) {
                return $result;
            } else {
                echo 'Nenhum registro encontrado!';
                return false;
            }
        } catch (Exception $e) {
            echo "Erro ao consultar Banco: " . $e->getMessage();
        }
    } 

    function insertFromDb (mysqli $conn, string $tabela, string $valores) {
        try {
            $codUsuarioAnterior = selectFromDb($conn, 'cod_usuario', 'tb_usuarios', null, 'cod_usuario desc', 1);
                
            if ($codUsuarioAnterior) {
                while ($row = mysqli_fetch_assoc($codUsuarioAnterior)) {
                    settype($row['cod_usuario'],'integer');
                    $id = $row['cod_usuario'] + 1;
                }
            }

            $sql = "INSERT INTO $tabela VALUES ($id, $valores)";
            return mysqli_query($conn, $sql);
        } catch (Exception $e) {
            echo"Erro ao inserir no Banco: " . $e->getMessage();
        }
    } 
?>