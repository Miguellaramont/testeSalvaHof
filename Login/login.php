<?php
session_start();

// se estiver recebendo JSON
$input = file_get_contents('php://input');
file_put_contents(__DIR__ . '/login_debug.log', date('c') . " RAW: " . $input . PHP_EOL, FILE_APPEND);

$dados = json_decode($input, true);
$email = $dados['email'] ?? null;
$senha = $dados['senha'] ?? null;

file_put_contents(__DIR__ . '/login_debug.log', date('c') . " EMAIL: $email SENHA: $senha" . PHP_EOL, FILE_APPEND);

// ... resto do código de login

$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>Login</title>
</head>

<body>
<div class="login-wrapper">
    <div class="login-form">
        <h1>Bem-vindo</h1>
        <p>Entre com suas credenciais para acessar o sistema.</p>

        <?php if ($msg): ?>
            <div class="msg"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="post" action="auth.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required placeholder="seu@email.com">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input id="senha" type="password" name="senha" required placeholder="Senha">
            </div>
            <button id = 'button-login' type="submit" >Entrar</button>
            <div class="login-extra">   
                <a href="#">Esqueci a senha</a>
            </div>
        </form>
    </div>
    <div class="side-brand">
        <div class="side-inner">
            <div class="logo-mark"></div>
        </div>
    </div>
</div>
<script src="api.js"></script>
</body>
</html>
