<?php
require "../config.php";

$nome = $_POST['nome'];
$descricao = $_POST['descricao'] ?? null;
$pais   = $_POST['pais_origem'] ?? null;
$fabricante = $_POST['fabricante'] ?? null;
$icone = $_POST['icone'] ?? null;

$sql = $mysqli->prepare("INSERT INTO marcas (nome, descricao, pais_origem, fabricante) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $nome, $descricao, $pais, $fabricante);

$sql->execute();

header("Location: catalogo_marcas.php?ok=1");
exit;
