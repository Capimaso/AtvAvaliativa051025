<?php require_once('../auth.php');?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercício 7 - Comparação de Valores A e B</title>
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
        .resultado-message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 1.2rem;
            text-align: center;
            animation: fadeIn 0.5s ease forwards;
            line-height: 1.4;
            font-family: monospace; /* Para ênfase nos valores */
            background-color: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid #4CAF50;
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
        .inputs-container {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }
        .inputs-container label {
            text-align: center;
            flex: 1;
        }
        .inputs-container input {
            width: 100%;
        }
        /* Animações */
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
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
            .inputs-container {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Detecta parâmetros GET para mostrar resultado
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $valorA = isset($_GET['A']) ? floatval($_GET['A']) : 0;
    $valorB = isset($_GET['B']) ? floatval($_GET['B']) : 0;
    $mostrarResultado = !empty($status) && ($valorA !== 0 || $valorB !== 0);
    ?>
    
    <div class="container">
        <h2>Exercício 7 - Comparação de Valores A e B</h2>
        
        <div class="descricao">
            Insira dois valores numéricos (A e B) abaixo para comparar se A é maior ou menor que B.
        </div>
        
        <?php if ($mostrarResultado): ?>
            <div class="resultado-message">
                <?php echo number_format($valorA, 2); ?> é <?php echo $status; ?> que <?php echo number_format($valorB, 2); ?>!
            </div>
        <?php endif; ?>
        
        <form method="POST" action="../exercicios\exec07.php">
            <div class="inputs-container">
                <div>
                    <label for="A">Valor A:</label>
                    <input type="number" 
                           id="A" 
                           name="A" 
                           required 
                           step="any"
                           placeholder="Ex: 5"
                           value=<?php echo isset($_COOKIE['exec07_A']) ? htmlspecialchars($_COOKIE['exec07_A'], 2): ''; ?>
                           <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?>
                    />
                </div>
                <div>
                    <label for="B">Valor B:</label>
                    <input type="number" 
                           id="B" 
                           name="B" 
                           required 
                           step="any"
                           placeholder="Ex: 3"
                           value=<?php echo isset($_COOKIE['exec07_B']) ? htmlspecialchars($_COOKIE['exec07_B'], 2): ''; ?>
                           <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?>
                    />
                </div>
            </div>
            
            <button type="submit">Comparar Valores</button>
        </form>
        
        <!-- Link para voltar à lista de exercícios -->
        <a href="../exelist.php" style="display: inline-block; margin-top: 20px; color: #FF8C00; text-decoration: none; font-weight: 600;">← Voltar à Lista de Exercícios</a>
    </div>
</body>
</html>
