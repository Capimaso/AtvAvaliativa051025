<?php
session_start();
if($_SESSION){
    header("Location: exelist.php");
    die();
}

$erro = isset($_GET['erro']) && $_GET['erro'] == 1;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login e Cadastro</title>
<style>
  /* Reset básico */
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
  }
  .container {
    background: rgba(0, 31, 63, 0.85);
    padding: 40px 30px;
    border-radius: 12px;
    width: 320px;
    box-shadow: 0 8px 24px rgba(255, 140, 0, 0.4);
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
  }
  label {
    margin-bottom: 6px;
    font-weight: 600;
  }
  input[type="text"],
  input[type="password"] {
    padding: 10px 12px;
    margin-bottom: 20px;
    border-radius: 6px;
    border: none;
    font-size: 1rem;
  }
  input[type="text"]:focus,
  input[type="password"]:focus {
    outline: 2px solid #FF8C00;
    background-color: #f0f0f0;
    color: #000;
  }
  /* Efeito vermelho para erro */
  .form-error {
    border: 2px solid #ff4d4d !important;
    animation: shake 0.3s ease;
  }
  .error-message {
    color: #ff4d4d;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
    animation: fadeIn 0.5s ease forwards;
  }
  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-8px); }
    40%, 80% { transform: translateX(8px); }
  }
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  .buttons {
    display: flex;
    justify-content: space-between;
    gap: 10px;
  }
  button {
    flex: 1;
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
  }
  button:hover {
    background: linear-gradient(45deg, #FF8C00, #FF4500);
    transform: scale(1.05);
  }
</style>
</head>
<body>
  <div class="container">
    <h2>Entrar ou Cadastrar</h2>

    <?php if ($erro): ?>
      <div class="error-message">Login ou senha incorretos. Tente novamente.</div>
    <?php endif; ?>

    <form id="authForm" method="POST" action="login.php" onsubmit="return validarFormulario(event)">
      <label for="login">Login</label>
      <input type="text" id="login" name="login" required autocomplete="username" placeholder="Seu usuário" minlength="4"
        <?php if ($erro) echo 'class="form-error"'; ?>
      />
      
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha" required autocomplete="current-password" placeholder="Sua senha" minlength="3"
        <?php if ($erro) echo 'class="form-error"'; ?>
      />
      
      <!-- Campo oculto para tipo de ação -->
      <input type="hidden" id="tipoEntrada" name="tipoEntrada" value="" />
      
      <div class="buttons">
        <button type="submit" onclick="document.getElementById('tipoEntrada').value='login'">Login</button>
        <button type="submit" onclick="document.getElementById('tipoEntrada').value='cadastro'">Cadastrar</button>
      </div>
    </form>
  </div>

<script>
  function validarFormulario(event) {
    const login = document.getElementById('login').value.trim();
    const senha = document.getElementById('senha').value.trim();
    const tipo = document.getElementById('tipoEntrada').value;

    if (login.length < 4) {
      alert('O login deve ter no mínimo 4 caracteres.');
      event.preventDefault();
      return false;
    }
    if (senha.length < 3) {
      alert('A senha deve ter no mínimo 3 caracteres.');
      event.preventDefault();
      return false;
    }
    if (tipo !== 'login' && tipo !== 'cadastro') {
      alert('Por favor, selecione Login ou Cadastro.');
      event.preventDefault();
      return false;
    }
    return true;
  }
</script>
</body>
</html>
