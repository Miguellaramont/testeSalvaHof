<?php
require "../config.php";
$id = $_GET['id'];
$sql = "SELECT * FROM categorias WHERE id = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$categoria = mysqli_fetch_assoc($result);
echo json_encode($categoria);
?>
