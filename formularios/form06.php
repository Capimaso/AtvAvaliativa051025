<?php require_once('../auth.php');?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercício 6 - Impressão de Valores em Ordem Crescente</title>
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
            font-size: 1.1rem;
            text-align: center;
            animation: fadeIn 0.5s ease forwards;
            background-color: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        .ordenados-lista {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
            list-style: none;
        }
        .ordenados-lista li {
            padding: 10px;
            margin: 5px 0;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            transition: transform 0.2s ease;
        }
        .ordenados-lista li:hover {
            transform: scale(1.02);
        }
        /* Cores diferenciadas: menor (verde), médio (amarelo), maior (vermelho) */
        /* Para 5 valores: 1º (menor) verde, 2º-3º (médios) amarelo, 4º-5º (maiores) vermelho */
        .valor-menor {
            background-color: rgba(76, 175, 80, 0.3);
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        .valor-medio {
            background-color: rgba(255, 215, 0, 0.3);
            color: #FFD700;
            border: 1px solid #FFD700;
        }
        .valor-maior {
            background-color: rgba(244, 67, 54, 0.3);
            color: #f44336;
            border: 1px solid #f44336;
        }
        .ultimo-resultado {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 20px;
            font-style: italic;
            font-size: 0.9rem;
            border-left: 4px solid #FF8C00;
            text-align: left;
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
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }
        .inputs-container label {
            text-align: center;
            font-size: 0.9rem;
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
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            .ordenados-lista li {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php
    // Lê o cookie para mostrar o último resultado ordenado
    $ultimoResultado = isset($_COOKIE['exec06_resultado']) ? htmlspecialchars($_COOKIE['exec06_resultado']) : '';
    
    // Detecta parâmetros GET para mostrar resultado
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $ordenadosStr = isset($_GET['ordenados']) ? $_GET['ordenados'] : '';
    $ordenados = !empty($ordenadosStr) ? explode(',', $ordenadosStr) : [];
    $mostrarResultado = ($status === 'sucesso') && count($ordenados) === 5;
    ?>
    
    <div class="container">
        <h2>Exercício 6 - Impressão de Valores em Ordem Crescente</h2>
        
        <div class="descricao">
            Insira 5 números abaixo (A, B, C, D, E) para exibi-los em ordem crescente.
        </div>
        
        <?php if (!empty($ultimoResultado)): ?>
            <div class="ultimo-resultado">
                Último resultado: <?php echo $ultimoResultado; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($mostrarResultado): ?>
            <div class="resultado-message">
                Valores em ordem crescente:
            </div>
            
            <ul class="ordenados-lista">
                <?php 
                // Atribui classes baseadas na posição: 1º menor (verde), 2º-3º médio (amarelo), 4º-5º maior (vermelho)
                foreach ($ordenados as $index => $valor): 
                    $classe = '';
                    if ($index === 0) {
                        $classe = 'valor-menor';
                    } elseif ($index <= 2) { // 2º e 3º: médio
                        $classe = 'valor-medio';
                    } else { // 4º e 5º: maior
                        $classe = 'valor-maior';
                    }
                ?>
                    <li class="<?php echo $classe; ?>">
                        <?php echo number_format(floatval($valor), 2); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        
        <form method="POST" action="../exercicios\exec06.php">
            <div class="inputs-container">
                <div>
                    <label for="A">A:</label>
                    <input type="number" id="A" name="A" step="any" placeholder="Ex: 5" <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?> 
                    value=<?php echo isset($_COOKIE['exec06_A']) ? htmlspecialchars($_COOKIE['exec06_A'], 2): ''; ?>
                    />
                </div>
                <div>
                    <label for="B">B:</label>
                    <input type="number" id="B" name="B" step="any" placeholder="Ex: 2" <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?> 
                    value=<?php echo isset($_COOKIE['exec06_B']) ? htmlspecialchars($_COOKIE['exec06_B'], 2): ''; ?>
                    />
                </div>
                <div>
                    <label for="C">C:</label>
                    <input type="number" id="C" name="C" step="any" placeholder="Ex: 8" <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?> 
                    value=<?php echo isset($_COOKIE['exec06_C']) ? htmlspecialchars($_COOKIE['exec06_C'], 2): ''; ?>
                    />
                </div>
                <div>
                    <label for="D">D:</label>
                    <input type="number" id="D" name="D" step="any" placeholder="Ex: 1" <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?> 
                    value=<?php echo isset($_COOKIE['exec06_D']) ? htmlspecialchars($_COOKIE['exec06_D'], 2): ''; ?>
                    />
                </div>
                <div>
                    <label for="E">E:</label>
                    <input type="number" id="E" name="E" step="any" placeholder="Ex: 10" <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?> 
                    value=<?php echo isset($_COOKIE['exec06_E']) ? htmlspecialchars($_COOKIE['exec06_E'], 2): ''; ?>
                    />
                </div>
            </div>
            
            <button type="submit">Ordenar Valores</button>
        </form>
        
        <!-- Link para voltar à lista de exercícios -->
        <a href="../exelist.php" style="display: inline-block; margin-top: 20px; color: #FF8C00; text-decoration: none; font-weight: 600;">← Voltar à Lista de Exercícios</a>
    </div>
</body>
</html>
