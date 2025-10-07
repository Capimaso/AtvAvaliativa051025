<?php require_once('../auth.php');?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercício 2 - Tabuada de um Número</title>
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
        select {
            padding: 12px 15px;
            border-radius: 6px;
            border: none;
            font-size: 1rem;
            background-color: #f0f0f0;
            color: #000;
            text-align: center;
        }
        select:focus {
            outline: 2px solid #FF8C00;
            background-color: #fff;
        }
        /* Estilos para resultados */
        .input-sucesso {
            border: 2px solid #4CAF50 !important;
            animation: pulse-green 0.5s ease;
        }
        .resultado-message {
            padding: 12px;
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
        .tabuada-lista {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
            list-style: none;
        }
        .tabuada-lista li {
            padding: 8px 0;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        .tabuada-lista li:last-child {
            border-bottom: none;
        }
        .tabuada-tabela {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: center;
            border-collapse: collapse;
        }
        .tabuada-tabela th,
        .tabuada-tabela td {
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-size: 1.1rem;
        }
        .tabuada-tabela th {
            background: rgba(255, 140, 0, 0.3);
            color: #fff;
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
            .tabuada-tabela {
                font-size: 0.9rem;
            }
            .tabuada-tabela th,
            .tabuada-tabela td {
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Lê os cookies para preencher os últimos valores
    $ultimoNumero = isset($_COOKIE['exec02_numero']) ? intval($_COOKIE['exec02_numero']) : '';
    $ultimoFormato = isset($_COOKIE['exec02_formato']) ? $_COOKIE['exec02_formato'] : 'lista';
    
    // Detecta parâmetros GET para mostrar resultado
    $mostrarResultado = isset($_GET['numero']) && isset($_GET['formato']);
    $numeroExibido = isset($_GET['numero']) ? intval($_GET['numero']) : 0;
    $formatoExibido = isset($_GET['formato']) ? $_GET['formato'] : 'lista';
    ?>
    
    <div class="container">
        <h2>Exercício 2 - Tabuada de um Número</h2>
        
        <div class="descricao">
            Insira um número inteiro abaixo e escolha o formato de exibição para ver a tabuada de 0 a 10.
        </div>
        
        <?php if ($mostrarResultado): ?>
            <div class="resultado-message">
                Tabuada do número <?php echo htmlspecialchars($numeroExibido); ?> no formato "<?php echo ucfirst($formatoExibido); ?>":
            </div>
            
            <?php if ($formatoExibido === 'lista'): ?>
                <ul class="tabuada-lista">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <li><?php echo $numeroExibido; ?> × <?php echo $i; ?> = <?php echo $numeroExibido * $i; ?></li>
                    <?php endfor; ?>
                </ul>
            <?php else: ?>
                <table class="tabuada-tabela">
                    <thead>
                        <tr>
                            <th><?php echo $numeroExibido; ?> ×</th>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i <= 10; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $numeroExibido * $i; ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>
        
        <form method="POST" action="../exercicios\exec02.php">
            <label for="numero">Digite um número inteiro:</label>
            <input type="number" 
                   id="numero" 
                   name="numero" 
                   required 
                   min="0" 
                   max="100" 
                   step="1"
                   placeholder="Ex: 5"
                   value="<?php echo htmlspecialchars($ultimoNumero); ?>"
                   <?php if ($mostrarResultado) echo 'class="input-sucesso"'; ?>
            />
            
            <label for="formato">Formato de exibição:</label>
            <select id="formato" name="formato" required>
                <option value="lista" <?php echo ($ultimoFormato === 'lista') ? 'selected' : ''; ?>>Lista</option>
                <option value="tabela" <?php echo ($ultimoFormato === 'tabela') ? 'selected' : ''; ?>>Tabela</option>
            </select>
            
            <button type="submit">Gerar Tabuada</button>
        </form>
        
        <!-- Link para voltar à lista de exercícios -->
        <a href="../exelist.php" style="display: inline-block; margin-top: 20px; color: #FF8C00; text-decoration: none; font-weight: 600;">← Voltar à Lista de Exercícios</a>
    </div>
</body>
</html>
