<?php
require "../config.php";
$id = $_POST['id'];
$nome = $_POST['nome'];
$icone = $_POST['icone'] ?? null;
$descricao = $_POST['descricao'] ?? null;

$sql = "UPDATE categorias SET nome = ?, icone = ?, descricao = ? WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "sssi", $nome, $icone, $descricao, $id);
mysqli_stmt_execute($stmt);

header("Location: catalogo_categorias.php");
?>
