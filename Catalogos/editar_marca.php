<?php
require "../config.php";

$id = $_POST['id'];

$nome = $_POST['nome'];
$descricao = $_POST['descricao'] ?? null;
$pais = $_POST['pais_origem'] ?? null;
$fabricante = $_POST['fabricante'] ?? null;
$logo = $_POST['logo'] ?? null;

$stmt = $mysqli->prepare("
    UPDATE marcas 
    SET nome=?, descricao=?, pais_origem=?, fabricante=?, logo=?
    WHERE id = ?
");

$stmt->bind_param("sssssi", $nome, $descricao, $pais, $fabricante, $logo, $id);

$stmt->execute();

header("Location: catalogo_marcas.php?msg=Marca atualizada&type=success");
exit;
