<?php
require_once('auth.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Exercícios PHP</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="container">
        <h1>Lista de Exercícios PHP</h1>
        <ul class="exercicios-list">
            <li><a href="formularios\form01.php">Exercício 1 - Verificação de Número Positivo, Negativo ou Zero</a></li>
            <li><a href="formularios\form02.php">Exercício 2 - Tabuada de um Número</a></li>
            <li><a href="formularios\form03.php">Exercício 3 - Cálculo do Fatorial com Recursão</a></li>
            <li><a href="formularios\form04.php">Exercício 4 - Calculadora com SwitchCase</a></li>
            <li><a href="formularios\form05.php">Exercício 5 - Verificação de Número Par ou Ímpar</a></li>
            <li><a href="formularios\form06.php">Exercício 6 - Impressão de Valores em Ordem Crescente</a></li>
            <li><a href="formularios\form07.php">Exercício 7 - Comparação de Valores A e B</a></li>
            <li><a href="formularios\form08.php">Exercício 8 - Cálculo da Média Final de um Aluno</a></li>
            <li class="imagem-item">
                <img src="EstruturaExercicios.jpg" alt="Estrutura dos Exercícios" />
            </li>
        </ul>
        <!-- Botão que chama logout.php para remover cookie -->
        <form method="POST" action="logout.php" style="margin-top: 30px;">
            <button type="submit" class="btn-voltar">Voltar para Login</button>
        </form>
    </div>
</body>
</html>
