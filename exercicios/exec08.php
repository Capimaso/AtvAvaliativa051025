<?php require_once('../auth.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $A1 = floatval($_POST['A1']);
    $A2 = floatval($_POST['A2']);
    $A3 = floatval($_POST['A3']);
    $REC = floatval($_POST['REC']);
    $mediaInicial = (($A1*2) + ($A2*2) + $A3) / 5;
    
    if ($REC > 0) {
        $mediaFinal = ($mediaInicial + $REC) / 2;
    } else {
        $mediaFinal = 0;
    }
    
    if ($mediaInicial >= 7) {
        $status = 'aprovado';
    } else {
        $status = 'reprovado';
    }

    setcookie('exec08_A1', $A1, time() + 3600, '/');
    setcookie('exec08_A2', $A2, time() + 3600, '/');
    setcookie('exec08_A3', $A3, time() + 3600, '/');
    header('Location: ../formularios/form08.php?status='. $status . '&media_inicial=' . $mediaInicial . '&media_final=' . $mediaFinal . '&rec=' . $REC);
    die();
}
?>
