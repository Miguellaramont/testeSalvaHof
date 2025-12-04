<?php
require "../config.php";

$sql = "SELECT * FROM marcas ORDER BY nome ASC";
$result = mysqli_query($mysqli, $sql);

$nome = $_SESSION['user_nome'] ?? "Usuário";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="../Dashboard/style.css">
    <link rel="stylesheet" href="catalogo.css">

    <title>Catálogo de Marcas</title>
</head>

<body>

    <?php include "../Dashboard/sidebar.php"; ?>

    <div class="main">

        <div class="topbar">
            <h2>Catálogo de Marcas</h2>
            <div class="topbar-right">
                <span><?= htmlspecialchars($nome) ?></span>
                <div class="avatar"></div>
            </div>
        </div>

        <div class="content">

            <h1>Lista de Marcas</h1>

            <button class="new-btn" onclick="openModalNovaMarca()">
                + Nova Marca
            </button>

            <div class="table-wrapper">
                <div class="table-title">Marcas Registradas</div>

                <div class="marca-grid">

                    <?php while ($m = mysqli_fetch_assoc($result)): ?>

                        <div class="marca-card">

                            <!-- Imagem da marca -->
                            <?php if (!empty($m['logo'])): ?>
                                <img src="<?= htmlspecialchars($m['logo']) ?>" class="marca-img">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x200?text=Sem+Logo" class="marca-img">
                            <?php endif; ?>

                            <!-- Nome da marca -->
                            <div class="marca-nome"><?= htmlspecialchars($m['nome']) ?></div>

                            <!-- País -->
                            <div class="marca-desc">
                                <?= !empty($m["pais_origem"]) ? "Origem: " . htmlspecialchars($m['pais_origem']) : "" ?>
                            </div>

                            <!-- Ações -->
                            <div class="marca-actions">

                                <button class="btn-edit"
                                    onclick="openModalEditarMarca(
                                        '<?= $m['id'] ?>',
                                        '<?= addslashes($m['nome']) ?>',
                                        '<?= addslashes($m['descricao']) ?>',
                                        '<?= addslashes($m['pais_origem']) ?>',
                                        '<?= addslashes($m['fabricante']) ?>',
                                        '<?= addslashes($m['logo']) ?>'
                                    )">
                                    Editar
                                </button>

                                <button class="btn-del" onclick="excluirMarca(<?= $m['id'] ?>);">
                                    Excluir
                                </button>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>
            </div>

        </div>
    </div>


    <!-- MODAL CADASTRAR / EDITAR MARCA -->
    <div class="popup-overlay" id="modalMarca">
        <div class="popup-content">

            <button class="close-btn" onclick="closeModalMarca()">&times;</button>

            <h2 id="modalTitle">Cadastrar Nova Marca</h2>

            <form id="formMarca" method="POST" action="nova_marca.php">

                <img id="previewLogo"
                    style="display:none;width:160px;height:160px;object-fit:contain;margin:10px auto;">

                <label>Logo da Marca (URL):</label>
                <input type="text" name="logo" id="marcaLogo" placeholder="https://exemplo.com/logo.png"
                    oninput="previewLogoMarca()">

                <label>Nome da Marca:</label>
                <input type="text" name="nome" id="marcaNome" required placeholder="Ex: OMO, Veja, Heineken">

                <label>Descrição (opcional):</label>
                <textarea name="descricao" id="marcaDescricao" rows="3"></textarea>

                <label>País de Origem:</label>
                <input type="text" name="pais_origem" id="marcaPais" placeholder="Ex: Brasil, EUA, Alemanha">

                <label>Fabricante:</label>
                <input type="text" name="fabricante" id="marcaFabricante" placeholder="Ex: Unilever">

                <input type="hidden" id="marcaId" name="id">

                <button class="save-btn" type="submit">Salvar Marca</button>
            </form>

        </div>
    </div>


    <script>
        /* Abrir modal de nova marca */
        function openModalNovaMarca() {
            document.getElementById("modalMarca").style.display = "flex";

            document.getElementById("modalTitle").innerText = "Cadastrar Nova Marca";
            document.getElementById("formMarca").action = "nova_marca.php";

            document.getElementById("marcaId").value = "";
            document.getElementById("marcaNome").value = "";
            document.getElementById("marcaLogo").value = "";
            document.getElementById("marcaDescricao").value = "";
            document.getElementById("marcaPais").value = "";
            document.getElementById("marcaFabricante").value = "";

            document.getElementById("previewLogo").style.display = "none";
        }

        /* Abrir modal de edição */
        function openModalEditarMarca(id, nome, descricao, pais, fabricante, logo) {
            document.getElementById("modalMarca").style.display = "flex";

            document.getElementById("modalTitle").innerText = "Editar Marca";
            document.getElementById("formMarca").action = "editar_marca.php";

            document.getElementById("marcaId").value = id;
            document.getElementById("marcaNome").value = nome;
            document.getElementById("marcaDescricao").value = descricao;
            document.getElementById("marcaPais").value = pais;
            document.getElementById("marcaFabricante").value = fabricante;
            document.getElementById("marcaLogo").value = logo;

            if (logo) {
                document.getElementById("previewLogo").src = logo;
                document.getElementById("previewLogo").style.display = "block";
            }
        }

        /* Fechar modal */
        function closeModalMarca() {
            document.getElementById("modalMarca").style.display = "none";
        }

        /* Preview da imagem */
        function previewLogoMarca() {
            const url = marcaLogo.value;
            const img = previewLogo;

            if (url.length > 5) {
                img.src = url;
                img.style.display = "block";
            } else {
                img.style.display = "none";
            }
        }

        /* Excluir marca */
        function excluirMarca(id) {
            if (confirm("Deseja realmente excluir esta marca?")) {
                window.location = "excluir_marca.php?id=" + id;
            }
        }
    </script>

</body>

</html>
