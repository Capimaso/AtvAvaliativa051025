<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numero = $_POST['numero'];
    $status = ($numero % 2 == 0) ? 'par' : 'impar';
    setcookie('exec05', $numero, time() + 3600, '/');
    header('Location: ../formularios\form05.php?status=' . $status . '&numero=' . $numero);
    die();
}