<?php
require "../config.php";  // conexão com o banco

// Verifica se recebeu o ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: catalogo_marcas.php?msg=ID da marca não informado&type=error");
    exit;
}

$id = (int) $_GET['id']; // segurança

// Verifica se existem produtos associados a esta marca
$check = mysqli_query($mysqli, "SELECT COUNT(*) AS total FROM produtos WHERE marca_id = $id");
$dados = mysqli_fetch_assoc($check);

if ($dados['total'] > 0) {
    header("Location: catalogo_marcas.php?msg=Não é possível excluir esta marca: existem produtos vinculados&type=warning");
    exit;
}

// Agora pode excluir
$sql = "DELETE FROM marcas WHERE id = $id";

if (mysqli_query($mysqli, $sql)) {
    header("Location: catalogo_marcas.php?msg=Marca excluída com sucesso&type=success");
    exit;
} else {
    header("Location: catalogo_marcas.php?msg=Erro ao excluir marca&type=error");
    exit;
}
