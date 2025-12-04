<?php
// auth.php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$stmt = $mysqli->prepare('SELECT id, nome, senha_hash FROM users WHERE email = ? LIMIT 1'); // uso de prepared statements [web:14][web:17]
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $nome, $hash);
    $stmt->fetch();

    if (password_verify($senha, $hash)) { // comparação segura da senha [web:16]
        $_SESSION['user_id'] = $id;
        $_SESSION['user_nome'] = $nome;
        header('Location: ../Dashboard/dashboard.php');
        exit;
    }
}

$_SESSION['msg'] = 'Email ou senha inválidos.';
header('Location: login.php');
exit;
