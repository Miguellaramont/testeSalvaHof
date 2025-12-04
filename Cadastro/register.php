<?php
// register.php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } else {
        $hash = password_hash($senha, PASSWORD_DEFAULT); // usa algoritmo forte recomendado [web:3][web:16]

        $stmt = $mysqli->prepare('INSERT INTO users (nome, email, senha_hash) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $nome, $email, $hash);
        if ($stmt->execute()) {
            $_SESSION['msg'] = 'Usuário cadastrado com sucesso. Faça login.';
            header('Location: ../Login/login.php');
            exit;
        } else {
            $erro = 'Erro ao cadastrar (talvez email já exista).';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar conta</title>
</head>
<body>
<form method="post"action="../auth.php">
    <input type="text" name="nome" placeholder="Nome completo">
    <input type="email" name="email" placeholder="Email">
    <input type="password" name="senha" placeholder="Senha">
    <button type="submit">Registrar</button>
    <?php if (!empty($erro)) echo '<p>'.$erro.'</p>'; ?>
</form>
</body>
</html>
