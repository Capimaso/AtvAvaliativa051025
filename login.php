<?php
session_start();

require('connector.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $usuario = $_POST['login'];
    $senha = $_POST['senha'];

    if (isset($_POST['tipoEntrada']) && $_POST['tipoEntrada'] === 'login'){
        $stmt = $pdo -> prepare("SELECT senha FROM Usuario WHERE usuario = :usuario"); //Prepara a entrada de dados para o stmt
        $stmt -> execute(['usuario' => $usuario]); //Entra esses dados no stmt completando os parametros passados ali em cima :)
        $row = $stmt -> fetch();

        if ($row && $senha == $row['senha']){
            $_SESSION['usuario'] = $usuario;
            header("Location: exelist.php");
            die();
        }else{
            header("Location: index.php?erro=1");
        }

    }else{
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $query = "INSERT INTO Usuario(usuario, senha) VALUES ('$usuario', '$senhaHash')";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $_SESSION['usuario'] = $usuario;
        header("Location: exelist.php");
        die();
    }
}   
