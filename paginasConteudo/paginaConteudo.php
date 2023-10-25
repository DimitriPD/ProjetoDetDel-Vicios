<?php 
    session_start();
    include_once(__DIR__ . "/../functions/index.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Chamar os links Css aqui quando criados -->
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php 
        if (!isset($_SESSION['id'])) {
            $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
            header('Location: ../index.php');
        }
        
        createHeader($_SESSION['tipo_usuario']);
    ?>
</body>
</html>