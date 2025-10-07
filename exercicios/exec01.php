<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numero = $_POST['numero'];

    if ($numero > 0){
        $status = 'positivo';
    }elseif ($numero < 0){
        $status = 'negativo';
    }else{
        $status = 'zero';
    }

    setcookie('exec01', $numero, time() + 3600, '/');

    header('Location: ../formularios\form01.php?status=' . $status . '&numero=' . urlencode($numero));
    die();
}else{
    header('Location: ../formularios\form01.php');
    die();
}
    

    