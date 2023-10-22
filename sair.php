<?php 
    session_start();
    ob_start();
    unset($_SESSION["id"], $_SESSION['$tipo_usuario']);
    header('Location: ./index.php');