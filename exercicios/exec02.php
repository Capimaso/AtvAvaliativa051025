<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numero = $_POST['numero'];
    $formato = $_POST['formato'];

    setcookie('exec02_numero', $numero, time() + 3600, '/');
    setcookie('exec02_formato', $numero, time() + 3600, '/');

    header('Location: ../formularios\form02.php?formato=' . $formato . '&numero=' . urlencode($numero));
    die();
}else{
    header('Location: ../formularios\form02.php');
    die();
}