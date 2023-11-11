<?php   
    // Funcao select from SQL
    function selectFromDb (mysqli $conn, string $atributos, string $tabela, string $condicao = null,  string $grupo = null, string $ordena = null, int $limita = null) {
        try { // Tenta realizar o select
            $sql = "SELECT $atributos FROM $tabela "; // sql minimo

            if ($condicao !== null) {  // caso queira add um WHERE
                $sql .= "WHERE $condicao "; // concatena $sql a cláusula WHERE
            }

            
            if ($grupo !== null) {
                $sql .= "GROUP BY $grupo ";
            }
            
            if ($ordena !== null) { // caso queira add um ORDER BY
                $sql .= "ORDER BY $ordena "; // concatena $sql a cláusula ORDER BY
            }
            if ($limita !== null) { // caso queira add um LIMIT
                $sql .= "LIMIT $limita "; // concatena $sql a cláusula LIMIT
            }

            error_log($sql);

            $result = mysqli_query($conn, $sql); // realiza query
            $resultCheck = mysqli_num_rows( $result ); // retorna numero de linhas geradas a partir da query

            if ($resultCheck > 0) { // se tiver pelo menos 1 linha retornada
                return $result;
            } else { // se não tiver nenhuma linha retornado
                return false;
            }
        } catch (Exception $e) { // se tiver algum erro na hora de fazer a query, exibe na tela qual foi
            echo "Erro ao consultar Banco: " . $e->getMessage();
        }
    } 

    // Funcao insert into SQL
    function insertIntoDb (mysqli $conn, string $tabela, string $valores) {
        try { // Tenta realizar o insert
            $sql = "INSERT INTO $tabela VALUES ($valores)";
            mysqli_query($conn, $sql); // realiza a query            
        } catch (Exception $e) { // se tiver algum erro na hora de fazer a query, exibe na tela qual foi
            echo"Erro ao inserir no Banco: " . $e->getMessage(); 
        }
    } 

    //Funcao delete sql

    function deleteDb(mysqli $conn, string $tabela, string $campo,int $id) {
        try {
            mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=0'); // realiza a query  
            $sql = "DELETE FROM $tabela WHERE $campo = $id ";
            mysqli_query($conn, $sql); // realiza a query  
        } catch (Exception $e) { // se tiver algum erro na hora de fazer a query, exibe na tela qual foi
            echo"Erro ao deletar do Banco: " . $e->getMessage(); 
        }
    }

    function updateInDb(mysqli $conn, string $tabela, array $dados, string $condicao) {
      try {
          $setClause = '';
  
          // Constrói a cláusula SET
          foreach ($dados as $coluna => $valor) {
              $setClause .= "$coluna = '$valor', ";
          }
  
          $setClause = rtrim($setClause, ', '); // Remove a última vírgula e espaço
  
          $sql = "UPDATE $tabela SET $setClause WHERE $condicao";
  
          error_log($sql);
  
          $result = mysqli_query($conn, $sql);
  
          if ($result) {
              return true; // Operação de update bem-sucedida
          } else {
              return false; // Falha na operação de update
          }
      } catch (Exception $e) {
          echo "Erro ao atualizar Banco: " . $e->getMessage();
      }
  }
?>