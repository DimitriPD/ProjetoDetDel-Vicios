<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/formulario.css">
    <link rel="stylesheet" href="./css/usuarios.css">
    <link rel="stylesheet" href="./css/relatos.css">
    
    <link rel="shortcut icon" href="./img/icones/detdelunity.jpeg" type="image/x-icon">

    <title>Projeto DetDelDel</title>
</head>

<?php
    include_once('./connection.php');  
    include_once('./crudFunc.php');  

    // Cria o header da página, assim não tem que criar um header em cada página
    function createHeader(array $links) {
        echo "
            <header>
                <div class='logo-header'>
                    <h1>Logo</h1>
                </div>
        
                <nav>
                    <ul class='nav-list'>";
                        foreach ($links as $link) {
                            $link =  ucfirst($link);
                            echo "<li class='list-item'>
                                <a href='./$link.php'>$link</a>
                            </li>";
                        }
                    echo "</ul>
                </nav>
            </header> 
        ";
    }

    // Cria o footer da página, assim não tem que criar um header em cada página
    $footer = 
    '<footer>
        <p>testessssssssssss</p>
    </footer>';
?>


    
