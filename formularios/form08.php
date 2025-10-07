<?php require_once('../auth.php');?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Exercício 8 - Média SGA com Recuperação</title>
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
        }
        .resultado-aprovado {
            background-color: rgba(76, 175, 80, 0.2); /* Verde para aprovado */
            color: #4CAF50;
            border: 1px solid #4CAF50;
        }
        .resultado-reprovado {
            background-color: rgba(244, 67, 54, 0.2); /* Vermelho para reprovado */
            color: #f44336;
            border: 1px solid #f44336;
        }
        .resultado-recuperacao {
            background-color: rgba(255, 193, 7, 0.2); /* Amarelo para recuperação */
            color: #FF9800;
            border: 1px solid #FF9800;
            font-style: italic;
        }
        .recuperacao-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            padding: 10px;
            margin: 10px 0;
            font-size: 0.95rem;
            border-left: 4px solid #FF9800;
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
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }
        .inputs-container label {
            text-align: center;
            font-size: 0.9rem;
        }
        .inputs-container input {
            width: 100%;
        }
        .rec-field {
            grid-column: 1 / -1; /* REC ocupa linha inteira */
            margin-top: 10px;
        }
        .rec-field label {
            text-align: center;
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
            .inputs-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Detecta parâmetros GET para mostrar resultado
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $mediaInicial = isset($_GET['media_inicial']) ? floatval($_GET['media_inicial']) : 0;
    $mediaFinal = isset($_GET['media_final']) ? floatval($_GET['media_final']) : 0;
    $recNota = isset($_GET['rec']) ? floatval($_GET['rec']) : 0;
    $mostrarResultado = !empty($status);
    $precisaRec = ($status === 'reprovado' && $recNota == 0);
    ?>
    
    <div class="container">
        <h2>Exercício 8 - Média SGA com Recuperação</h2>
        
        <div class="descricao">
            Insira as três notas (A1, A2, A3) para calcular a média ponderada: ((A1*2) + (A2*2) + (A3*1)) / 5.<br>
            Se a média < 7, o aluno está reprovado e pode fazer recuperação (REC). Nova média: (média + REC) / 2.
        </div>
        
        <?php if ($mostrarResultado): ?>
            <?php if ($status === 'aprovado'): ?>
                <div class="resultado-message resultado-aprovado">
                    Média inicial: <?php echo number_format($mediaInicial, 2); ?> - Situação: Aprovado!
                </div>
            <?php elseif ($status === 'reprovado' && $recNota > 0): ?>
                <div class="resultado-message resultado-recuperacao">
                    Média inicial: <?php echo number_format($mediaInicial, 2); ?> (Reprovado).<br>
                    Nota de recuperação: <?php echo number_format($recNota, 2); ?>.<br>
                    Nova média: <?php echo number_format($mediaFinal, 2); ?> - Situação: 
                    <?php echo ($mediaFinal >= 7) ? 'Aprovado com Recuperação!' : 'Reprovado mesmo com Recuperação!'; ?>
                </div>
            <?php else: ?>
                <div class="resultado-message resultado-reprovado">
                    Média inicial: <?php echo number_format($mediaInicial, 2); ?> - Situação: Reprovado!<br>
                    <?php if ($precisaRec): ?>
                        Insira a nota de recuperação (REC) para calcular a nova média.
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($precisaRec): ?>
                <div class="recuperacao-info">
                    Dica: A nova média será calculada como (<?php echo number_format($mediaInicial, 2); ?> + REC) / 2. Para aprovação, REC precisa ser ≥ <?php echo number_format((14 - $mediaInicial), 2); ?>.
                </div>
            <?php endif; ?>
        <?php endif; ?>
        
        <form method="POST" action="../exercicios/exec08.php">
            <div class="inputs-container">
                <div>
                    <label for="A1">Nota A1 (peso 2):</label>
                    <input type="number" 
                           id="A1" 
                           name="A1" 
                           required 
                           min="0" 
                           max="10" 
                           step="0.1"
                           placeholder="0-10"
                           <?php if ($mostrarResultado && $status === 'aprovado') echo 'class="input-sucesso"'; ?>
                           <?php if ($mostrarResultado && $status === 'reprovado') echo 'class="input-erro"'; ?>
                    />
                </div>
                <div>
                    <label for="A2">Nota A2 (peso 2):</label>
                    <input type="number" 
                           id="A2" 
                           name="A2" 
                           required 
                           min="0" 
                           max="10" 
                           step="0.1"
                           placeholder="0-10"
                           <?php if ($mostrarResultado && $status === 'aprovado') echo 'class="input-sucesso"'; ?>
                           <?php if ($mostrarResultado && $status === 'reprovado') echo 'class="input-erro"'; ?>
                    />
                </div>
                <div>
                    <label for="A3">Nota A3 (peso 1):</label>
                    <input type="number" 
                           id="A3" 
                           name="A3" 
                           required 
                           min="0" 
                           max="10" 
                           step="0.1"
                           placeholder="0-10"
                           <?php if ($mostrarResultado && $status === 'aprovado') echo 'class="input-sucesso"'; ?>
                           <?php if ($mostrarResultado && $status === 'reprovado') echo 'class="input-erro"'; ?>
                    />
                </div>
            </div>
            
            <?php if ($precisaRec): ?>
                <div class="rec-field">
                    <label for="REC">Nota de Recuperação (REC):</label>
                    <input type="number" 
                           id="REC" 
                           name="REC" 
                           min="0" 
                           max="10" 
                           step="0.1"
                           placeholder="0-10 (obrigatório para nova média)"
                           required 
                    />
                </div>
            <?php else: ?>
                <input type="number" 
                       id="REC" 
                       name="REC" 
                       min="0" 
                       max="10" 
                       step="0.1"
                       placeholder="REC (opcional se reprovado)"
                       style="display: none;"
                       value="0" 
                />
            <?php endif; ?>
            
            <button type="submit">
                <?php echo ($precisaRec) ? 'Calcular com Recuperação' : 'Calcular Média'; ?>
            </button>
        </form>
        
        <!-- Link para voltar à lista de exercícios -->
        <a href="../exelist.php" style="display: inline-block; margin-top: 20px; color: #FF8C00; text-decoration: none; font-weight: 600;">← Voltar à Lista de Exercícios</a>
    </div>
</body>
</html>
