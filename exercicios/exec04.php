<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $num1 =  $_POST['num1'];
    $num2 =  $_POST['num2'];
    $operacao =  $_POST['operacao'];

    if ($num1 && $num2){
        switch($operacao){
            case '+':
                $resultado = $num1 + $num2;
                break;
            case '-':
                $resultado = $num1 - $num2;
                break;
            case '*':
                $resultado = $num1 * $num2;
                break;
            case '/':
                $resultado = $num1 / $num2;
                break;
            case '^':
                $resultado = $num1 ** $num2;
                break;
        } 
        $status = 'sucesso';
        setcookie('exec04_ultimo', $resultado, time() + 3600, '/');
        setcookie('exec04_num2', $num2, time() + 3600, '/');
        setcookie('exec04_num1', $num1, time() + 3600, '/');
    }elseif ($num1 && $operacao == '√'){
        $resultado = sqrt($num1);
        $status = 'sucesso';
        setcookie('exec04_num1', $resultado, time() + 3600, '/');
        setcookie('exec04_ultimo', $resultado, time() + 3600, '/');
    }else{
        $status = 'erro';
    }
    

    header('Location: ../formularios\form04.php?resultado=' . $resultado . '&expressao=' . $operacao . '&status=' . $status);
    die();
}else{
    header('Location: ../formularios\form04.php');
    die();
}