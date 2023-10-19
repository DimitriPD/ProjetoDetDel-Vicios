<?php   
    function selectFromDb (mysqli $conn, string $atributos, string $tabela, string $condicao = null, string $ordena = null) {
        try {
            $sql = "SELECT $atributos FROM $tabela ";

            if ($condicao !== null) { 
                $sql .= "WHERE $condicao ";
            }

            if ($ordena !== null) {
                $sql .= "ORDER BY $ordena";
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
            $id = 14;
            $sql = "INSERT INTO $tabela values ($id, $valores)";
            $result = mysqli_query($conn, $sql);
            $linhas = mysqli_affected_rows( $conn );
        } catch (Exception $e) {
            echo"Erro ao inserir no Banco: " . $e->getMessage();
        }
    } 
?>