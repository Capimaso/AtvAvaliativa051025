<?php

$usuario = "root";
$senha  = "";
$dbname = "Usuario";
$host   = "localhost";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $senha);
    var_dump($pdo);
} catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
}