<?php
require "../config.php";  // conexão com o banco

// Verifica se recebeu o ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: catalogo_categorias.php?msg=ID da categoria não informado&type=error");
    exit;
}

$id = (int) $_GET['id']; // segurança: garante número

// Verifica se existe produto usando esta categoria
$check = mysqli_query($mysqli, "SELECT COUNT(*) AS total FROM produtos WHERE categoria_id = $id");
$dados = mysqli_fetch_assoc($check);

if ($dados['total'] > 0) {
    header("Location: catalogo_categorias.php?msg=Não é possível excluir: existem produtos associados&type=warning");
    exit;
}

// Agora pode excluir
$sql = "DELETE FROM categorias WHERE id = $id";

if (mysqli_query($mysqli, $sql)) {
    header("Location: catalogo_categorias.php?msg=Categoria excluída com sucesso&type=success");
    exit;
} else {
    header("Location: catalogo_categorias.php?msg=Erro ao excluir categoria&type=error");
    exit;
}
