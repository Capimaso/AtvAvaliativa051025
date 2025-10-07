<?php require_once('../auth.php');?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercício 3 - Cálculo do Fatorial (Recursivo)</title>
    <style>
        /* Reset básico e estilo inspirado na tela de login */
        * {
            box-sizing: border-box;
        }
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #001F3F 0%, #003366 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: rgba(0, 31, 63, 0.85);
            padding: 40px 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 24px rgba(255, 140, 0, 0.4);
            text-align: center;
        }
        h2 {
            text-align: center;
            margin-bottom: 24px;
            font-weight: 700;
            font-size: 1.8rem;
            background: linear-gradient(45deg, #FF4500, #FF8C00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: 600;
            text-align: left;
            margin-bottom: 6px;
        }
        input[type="number"] {
            padding: 12px 15px;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
            background-color: #f0f0f0;
            color: #000;
            text-align: center;
        }
        input[type="number"]:focus {
            outline: 2px solid #FF8C00;
            background-color: #fff;
        }
        /* Estilos para resultados */
        .input-sucesso {
            border: 2px solid #4CAF50 !important;
            animation: pulse-green 0.5s ease;
        }
        .input-erro {
            border: 2px solid #f44336 !important;
            animation: shake 0.3s ease;
        }
        .resultado-message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            animation: fadeIn 0.5s ease forwards;
            line-height: 1.4;
            white-space: pre-wrap; /* Para preservar quebras de linha se necessário */
        }
        .resultado-sucesso {
            background-color: rgba(76, 175, 80, 0.2); /* Verde claro para sucesso */
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        .resultado-erro {
            background-color: rgba(244, 67, 54, 0.2); /* Vermelho para erro */
            color: #f44336;
            border: 1px solid #f44336;
        }
        .fatorial-calculo {
            font-size: 1.2rem;
            margin-top: 10px;
            font-family: monospace; /* Para melhor visualização da multiplicação */
        }
        button {
            padding: 12px 0;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(45deg, #FF4500, #FF8C00);
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.6);
            transition: background 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
        }
        button:hover {
            background: linear-gradient(45deg, #FF8C00, #FF4500);
            transform: scale(1.05);
        }
        .descricao {
            margin-bottom: 20px;
            font-size: 1rem;
            line-height: 1.4;
            text-align: left;
        }
        /* Animações */
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-8px); }
            40%, 80% { transform: translateX(8px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Responsividade */
        @media (max-width: 480px) {
            .container {
                width: 95vw;
                padding: 30px 20px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .fatorial-calculo {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php
    // Lê o cookie para preencher o último número inserido
    $ultimoNumero = isset($_COOKIE['ex03_ultimo']) ? intval($_COOKIE['ex03_ultimo']) : '';
    
    // Detecta parâmetros GET para mostrar resultado
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $numeroExibido = isset($_GET['numero']) ? intval($_GET['numero']) : 0;
    $resultadoFatorial = isset($_GET['resultado']) ? intval($_GET['resultado']) : 0;
    $calculoString = isset($_GET['calculo']) ? urldecode($_GET['calculo']) : '';
    $mostrarResultado = !empty($status) && $numeroExibido >= 0;
    ?>
    
    <div class="container">
        <h2>Exercício 3 - Cálculo do Fatorial (Recursivo)</h2>
        
        <div class="descricao">
            Insira um número inteiro entre 0 e 20 abaixo para calcular seu fatorial de forma recursiva.<br>
            O fatorial de n (n!) é o produto de todos os inteiros positivos de 1 até n.
        </div>
        
        <?php if ($mostrarResultado): ?>
            <div class="resultado-message resultado-<?php echo $status; ?>">
                <?php if ($status === 'sucesso'): ?>
                    <div class="fatorial-calculo"><?php echo htmlspecialchars($numeroExibido); ?>! = <?php echo htmlspecialchars($calculoString); ?> = <?php echo number_format($resultadoFatorial); ?></div>
                <?php else: ?>
                    Erro: O número deve estar entre 0 e 20. Você inseriu <?php echo htmlspecialchars($numeroExibido); ?>.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="../exercicios\exec03.php">
            <label for="numero">Digite um número inteiro (0-20):</label>
            <input type="number" 
                   id="numero" 
                   name="numero" 
                   required 
                   min="0" 
                   max="20" 
                   step="1"
                   placeholder="Ex: 5"
                   value="<?php echo htmlspecialchars($ultimoNumero); ?>"
                   <?php 
                   if ($mostrarResultado) {
                       echo 'class="input-' . $status . '"';
                   }
                   ?>
            />
            
            <button type="submit">Calcular Fatorial</button>
        </form>
        
        <!-- Link para voltar à lista de exercícios -->
        <a href="../exelist.php" style="display: inline-block; margin-top: 20px; color: #FF8C00; text-decoration: none; font-weight: 600;">← Voltar à Lista de Exercícios</a>
    </div>
</body>
</html>
