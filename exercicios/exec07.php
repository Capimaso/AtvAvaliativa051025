<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $num1 = $_POST['A'];
    $num2 = $_POST['B'];
    if ($num1 > $num2){
        $status = 'maior';
    }else if ($num1 < $num2){
        $status = 'menor';
    }else{
        $status = 'o mesmo';
    }

    setcookie('exec07_A', $num1, time() + 3600, '/');
    setcookie('exec07_B', $num2, time() + 3600, '/');
    header('Location: ../formularios\form07.php?status='. $status . '&A=' . $num1 . '&B=' . $num2);
    die();
}