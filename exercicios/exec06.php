<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $A = floatval($_POST['A'] ?? 0);
    $B = floatval($_POST['B'] ?? 0);
    $C = floatval($_POST['C'] ?? 0);
    $D = floatval($_POST['D'] ?? 0);
    $E = floatval($_POST['E'] ?? 0);
    $numeros = array($A, $B, $C, $D, $E);
    sort($numeros);
    $ordenadosStr = implode(',', $numeros);
    setcookie('exec06_A', $A, time() + 3600, '/');
    setcookie('exec06_B', $B, time() + 3600, '/');
    setcookie('exec06_C', $C, time() + 3600, '/');
    setcookie('exec06_D', $D, time() + 3600, '/');
    setcookie('exec06_E', $E, time() + 3600, '/');
    header('Location: ../formularios\form06.php?status=sucesso&ordenados=' . urlencode($ordenadosStr));
    die();

}