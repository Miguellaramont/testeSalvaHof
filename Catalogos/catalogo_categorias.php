<?php
require "../config.php";

// pega categorias
$sql = "SELECT * FROM categorias ORDER BY nome ASC";
$result = mysqli_query($mysqli, $sql);

// nome usuário
$nome = $_SESSION['user_nome'] ?? 'Usuário';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <!-- CSS global da dashboard -->
    <link rel="stylesheet" href="../Dashboard/style.css">

    <!-- CSS específico do catálogo -->
    <link rel="stylesheet" href="catalogo.css">

    <title>Catálogo de Marcas</title>
</head>

<body>

    <!-- ALERTA DO SISTEMA -->
    <div class="alert-container" id="alertBox">
        <div class="alert-message" id="alertMessage"></div>
    </div>
    <?php if (isset($_GET['msg'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                showAlert("<?= $_GET['msg'] ?>", "<?= $_GET['type'] ?? 'success' ?>");
            });
        </script>
    <?php endif; ?>


    <!-- SIDEBAR -->
    <?php include "../Dashboard/sidebar.php"; ?>

    <!-- MAIN -->
    <div class="main">

        <div class="topbar">
            <h2>Catálogo de Categorias</h2>
            <div class="topbar-right">
                <span><?= htmlspecialchars($nome) ?></span>
                <div class="avatar"></div>
            </div>
        </div>

        <div class="content">

            <h1>Lista de Categorias</h1>

            <button onclick="openPopupCategoria()" class="new-btn">
                + Nova Categoria
            </button>

            <div class="table-wrapper">
                <div class="table-title">Categorias Registradas</div>

                <div class="categoria-grid">

                    <?php while ($c = mysqli_fetch_assoc($result)): ?>

                        <div class="categoria-card" onclick="window.location='produtos.php?categoria=<?= $c['id'] ?>'">

                            <!-- Ícone -->
                            <?php if ($c['icone']): ?>
                                <img src="<?= $c['icone'] ?>" alt="ícone" width="48" height="48">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/48" alt="categoria" width="48" height="48">
                            <?php endif; ?>

                            <!-- Nome -->
                            <div class="cat-nome"><?= htmlspecialchars($c['nome']) ?></div>

                            <!-- Descrição curta -->
                            <div class="cat-desc">
                                <?= $c['descricao'] ? htmlspecialchars(substr($c['descricao'], 0, 40)) . '...' : '' ?>
                            </div>

                            <!-- Ações -->
                            <div class="cat-actions">

                                <button class="btn-edit"
                                    onclick="event.stopPropagation(); editarCategoria(<?= $c['id'] ?>);">
                                    Editar
                                </button>

                                <button class="btn-del"
                                    onclick="event.stopPropagation(); excluirCategoria(<?= $c['id'] ?>);">
                                    Excluir
                                </button>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            </div>

        </div>

    </div>


    <!-- MODAL NOVA CATEGORIA -->
    <div class="popup-overlay" id="popupCategoria">
        <div class="popup-content">

            <button class="close-btn" onclick="closePopupCategoria()">&times;</button>

            <h2>Cadastrar Nova Categoria</h2>
            <p>Preencha as informações abaixo:</p>

            <form action="nova_categoria.php" method="POST">

                <img id="previewIcon"
                    style="display:none;width:120px;height:120px;object-fit:contain;margin-bottom:15px;">

                <label>URL do Ícone (opcional):</label>
                <input type="text" name="icone" id="inputIcone" placeholder="https://exemplo.com/icon.png"
                    oninput="previewCategoriaIcon()">

                <label>Nome da Categoria:</label>
                <input type="text" name="nome" required placeholder="Ex: Aromatizantes, Ácidos, Material Escolar">

                <label>Descrição (opcional):</label>
                <textarea name="descricao" rows="4" placeholder="Descreva brevemente a categoria..."></textarea>

                <button class="save-btn" type="submit">Salvar Categoria</button>

            </form>
        </div>
    </div>

    <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
    <div class="popup-overlay" id="confirmDelete">
        <div class="popup-content" style="max-width: 380px;">

            <button class="close-btn" onclick="closeDeleteModal()">&times;</button>

            <h2>Excluir Categoria</h2>
            <p>Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita.</p>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button class="save-btn" style="background:#e63946;" id="btnConfirmDelete">
                    Excluir
                </button>

                <button class="save-btn" style="background:#777;" onclick="closeDeleteModal()">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
    <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
    <div class="popup-overlay" id="confirmDelete">
        <div class="popup-content" style="max-width: 380px;">

            <button class="close-btn" onclick="closeDeleteModal()">&times;</button>

            <h2>Excluir Categoria</h2>
            <p>Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita.</p>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button class="save-btn" style="background:#e63946;" id="btnConfirmDelete">
                    Excluir
                </button>

                <button class="save-btn" style="background:#777;" onclick="closeDeleteModal()">
                    Cancelar
                </button>
            </div>

        </div>
    </div>

    <script>
        function toggleSubmenu(element) {
            element.classList.toggle("open");
            const submenu = element.nextElementSibling;

            if (submenu.style.maxHeight && submenu.style.maxHeight !== "0px") {
                submenu.style.maxHeight = "0px";
            } else {
                submenu.style.maxHeight = submenu.scrollHeight + "px";
            }
        }

        function openPopupCategoria() {
            document.getElementById("popupCategoria").style.display = "flex";
        }

        function closePopupCategoria() {
            document.getElementById("popupCategoria").style.display = "none";
        }

        function previewCategoriaIcon() {
            const url = document.getElementById("inputIcone").value;
            const preview = document.getElementById("previewIcon");

            if (url.length > 5) {
                preview.src = url;
                preview.style.display = "block";
            } else {
                preview.style.display = "none";
            }
        }

        function editarCategoria(id) {
            alert("Abrir modal de edição — ID " + id);
        }


        let categoriaParaExcluir = null;

        function excluirCategoria(id) {
            categoriaParaExcluir = id;
            document.getElementById("confirmDelete").style.display = "flex";
        }

        function closeDeleteModal() {
            categoriaParaExcluir = null;
            document.getElementById("confirmDelete").style.display = "none";
        }

        document.getElementById("btnConfirmDelete").onclick = function () {
            if (categoriaParaExcluir !== null) {
                window.location = "excluir_categoria.php?id=" + categoriaParaExcluir;
            }
        };


        function showAlert(msg, type = "success") {
            const alertBox = document.getElementById("alertBox");
            const alertMessage = document.getElementById("alertMessage");

            alertMessage.textContent = msg;

            // Estilos
            alertMessage.className = "alert-message";
            if (type === "error") alertMessage.classList.add("alert-error");
            if (type === "warning") alertMessage.classList.add("alert-warning");

            alertBox.style.display = "block";

            setTimeout(() => {
                alertBox.style.display = "none";
            }, 3000);
        }

    </script>

</body>

</html>