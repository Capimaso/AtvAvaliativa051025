<?php require_once('../auth.php');?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercício 5 - Verificação de Par ou Ímpar</title>
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
            max-width: 400px;
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
        .input-par {
            border: 2px solid #FFD700 !important; /* Amarelo para par */
            animation: pulse-yellow 0.5s ease;
        }
        .input-impar {
            border: 2px solid #9C27B0 !important; /* Roxo para ímpar */
            animation: pulse-purple 0.5s ease;
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
            font-family: monospace; /* Para ênfase no número */
        }
        .resultado-par {
            background-color: rgba(255, 215, 0, 0.2); /* Amarelo claro para par */
            color: #FFD700;
            border: 1px solid #FFD700;
        }
        .resultado-impar {
            background-color: rgba(156, 39, 176, 0.2); /* Roxo claro para ímpar */
            color: #9C27B0;
            border: 1px solid #9C27B0;
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
        @keyframes pulse-yellow {
            0% { box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 215, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 215, 0, 0); }
        }
        @keyframes pulse-purple {
            0% { box-shadow: 0 0 0 0 rgba(156, 39, 176, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(156, 39, 176, 0); }
            100% { box-shadow: 0 0 0 0 rgba(156, 39, 176, 0); }
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
        }
    </style>
</head>
<body>
    <?php
    // Lê o cookie para preencher o último número inserido
    $ultimoNumero = isset($_COOKIE['exec05']) ? intval($_COOKIE['exec05']) : '';
    
    // Detecta parâmetros GET para mostrar resultado
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $numeroExibido = isset($_GET['numero']) ? intval($_GET['numero']) : 0;
    $mostrarResultado = !empty($status) && $numeroExibido !== 0;
    ?>
    
    <div class="container">
        <h2>Exercício 5 - Verificação de Par ou Ímpar</h2>
        
        <div class="descricao">
            Insira um número inteiro abaixo para verificar se ele é <strong>par</strong> ou <strong>ímpar</strong>.
        </div>
        
        <?php if ($mostrarResultado): ?>
            <div class="resultado-message resultado-<?php echo $status; ?>">
                <?php echo htmlspecialchars($numeroExibido); ?> é <?php echo $status; ?>!
            </div>
        <?php endif; ?>
        
        <form method="POST" action="../exercicios\exec05.php">
            <label for="numero">Digite um número inteiro:</label>
            <input type="number" 
                   id="numero" 
                   name="numero" 
                   required 
                   min="-1000" 
                   max="1000" 
                   step="1"
                   placeholder="Ex: 7"
                   value="<?php echo htmlspecialchars($ultimoNumero); ?>"
                   <?php 
                   if ($mostrarResultado) {
                       echo 'class="input-' . $status . '"';
                   }
                   ?>
            />
            
            <button type="submit">Verificar Paridade</button>
        </form>
        
        <!-- Link para voltar à lista de exercícios -->
        <a href="../exelist.php" style="display: inline-block; margin-top: 20px; color: #FF8C00; text-decoration: none; font-weight: 600;">← Voltar à Lista de Exercícios</a>
    </div>
</body>
</html>
