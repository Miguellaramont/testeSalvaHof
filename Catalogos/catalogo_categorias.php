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

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-header">
            Salva Hof<br>
            <span style="font-size:11px;font-weight:400;">Seu varejista</span>
        </div>

        <div class="sidebar-nav">

            <a href="../Dashboard/dashboard.php">
                <div class="nav-item"><span>Painel de Controle</span></div>
            </a>
            <div class="nav-item"><span>Relatórios</span></div>
            <div class="nav-item"><span>Extravio</span></div>
            <div class="nav-item"><span>Vendas</span></div>

            <div class="nav-section-title">Gerenciamento</div>
            <div class="nav-item"><span>Usuários</span></div>
            <div class="nav-item"><span>Aplicativo</span></div>
            <div class="nav-item"><span>Notificações</span></div>
            <div class="nav-item"><span>Reposição</span></div>
            <div class="nav-item"><span>Ordens de Serviço</span></div>

            <div class="nav-section-title">Catálogo</div>

            <div class="nav-item open" onclick="toggleSubmenu(this)">
                <span>Catálogo</span>
                <span class="arrow">▶</span>
            </div>

            <div class="submenu" style="max-height:500px;">
                <a href="catalogo_marcas.php">
                    <div class="submenu-item">Catálogo de Marcas</div>
                </a>
                <a href="catalogo_categorias.php">
                    <div class="submenu-item active">Catálogo de Categorias</div>
                </a>
                <a href="produtos.php">
                    <div class="submenu-item">Produtos</div>
                </a>
            </div>

        </div>

        <div class="sidebar-footer">
            <div>Logado como: <br><strong><?= htmlspecialchars($nome) ?></strong></div>
            <div style="margin-top:6px;">
                <a href="../logout.php" style="color:#fff;text-decoration:none;">Sair</a>
            </div>
        </div>
    </div>

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
                                <img src="<?= $c['icone'] ?>" alt="ícone">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/48" alt="placeholder">
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

        function excluirCategoria(id) {
            if (confirm("Tem certeza que deseja excluir esta categoria?")) {
                window.location = "excluir_categoria.php?id=" + id;
            }
        }
    </script>

</body>

</html>