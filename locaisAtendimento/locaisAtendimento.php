<?php 
    session_start();
    include_once(__DIR__ . "/../functions/index.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/icones/detdelunity.jpeg" type="image/x-icon">

    <link rel="stylesheet" href="../style.css">

    <title>Projeto DetDelDel</title>
</head>

<body>
    <?php 
        if (!isset($_SESSION['id'])) {
            $_SESSION['msg'] = '<h1 class="session-error"> Necessário realizar Login para acessar a página! </h1>';
            header('Location: ../index.php');
        }
        
        createHeader($_SESSION['tipo_usuario'],$_SESSION['nome_usuario']);
    ?>
</body>
</html>