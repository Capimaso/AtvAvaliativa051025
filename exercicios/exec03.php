<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numero = $_POST['numero'];
    
    if ($numero >=0 && $numero <= 20){
        $status = 'sucesso';
        $resultado = $numero;
        $calculo = '' . $numero;

        for ($i = $numero - 1; $i > 0; $i--){
            $resultado = $resultado * $i;
            $calculo = $calculo . ' x ' . $i;
        }

        setcookie('exec03', $numero, time() + 3600, '/');
        header('Location: ../formularios\form03.php?status=' . $status . '&numero=' . urlencode($numero) . '&calculo=' . urlencode($calculo) . '&resultado=' . $resultado);
        die();
    }else{
        $status = 'erro';
        header('Location: ../formularios\form03.php?status=' . $status);
        die();
    }

}else{
    header('Location: ../formularios\form03.php');
    die();
}