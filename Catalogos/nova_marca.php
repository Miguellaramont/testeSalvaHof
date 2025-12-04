<?php
require "../config.php";

$nome = $_POST['nome'];
$descricao = $_POST['descricao'] ?? null;
$pais = $_POST['pais_origem'] ?? null;
$fabricante = $_POST['fabricante'] ?? null;
$logo = $_POST['logo'] ?? null;

$stmt = $mysqli->prepare("
    INSERT INTO marcas (nome, descricao, pais_origem, fabricante, logo)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $nome, $descricao, $pais, $fabricante, $logo);

$stmt->execute();

header("Location: catalogo_marcas.php?msg=Marca cadastrada com sucesso&type=success");
exit;
