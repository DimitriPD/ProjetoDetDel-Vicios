<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/formulario.css">
    <link rel="stylesheet" href="./css/usuarios.css">
    
    <link rel="shortcut icon" href="./img/icones/detdelunity.jpeg" type="image/x-icon">
    <script src="./js/script.js" defer></script>

    <title>Projeto DetDelDel</title>
</head>

<?php
    include_once('./connection.php');  
    include_once('./crudFunc.php');  

    $header = '
    <header>
        <div class="logo-header">
            <h1>Logo</h1>
        </div>

        <nav>
            <ul class="nav-list">
                <li class="list-item">
                    <a href="./index.php">Home</a>
                </li>
                <li class="list-item">
                    <a href="./formulario.php">Formulario</a>
                </li>
                <li class="list-item">
                    <a href="./usuarios.php">Usuários</a>
                </li>
            </ul>
        </nav>
    </header>';

    $footer = 
    '<footer>
        <p>testessssssssssss</p>
    </footer>';
?>


    
