<?php
require "../config.php";

$nome = $_POST['nome'];
$descricao = $_POST['descricao'] ?? null;
$icone = $_POST['icone'] ?? null;

$sql = $mysqli->prepare("
    INSERT INTO categorias (nome, descricao, icone)
    VALUES (?, ?, ?)
");

$sql->bind_param("sss", $nome, $descricao, $icone);
$sql->execute();

header("Location: catalogo_categorias.php?ok=1");
exit;
