<?php
require "../config.php";

// Consulta marcas
$sql = "SELECT * FROM marcas ORDER BY nome ASC";
$result = mysqli_query($mysqli, $sql);

// Nome do usuário (usado no topo)
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

            <!-- PRINCIPAL -->
            <a href="../Dashboard/dashboard.php">
                <div class="nav-item"><span>Painel de Controle</span></div>
            </a>
            <div class="nav-item"><span>Relatórios</span></div>
            <div class="nav-item"><span>Extravio</span></div>
            <div class="nav-item"><span>Vendas</span></div>

            <!-- GERENCIAMENTO -->
            <div class="nav-section-title">Gerenciamento</div>
            <div class="nav-item"><span>Usuários</span></div>
            <div class="nav-item"><span>Aplicativo</span></div>
            <div class="nav-item"><span>Notificações</span></div>
            <div class="nav-item"><span>Reposição</span></div>
            <div class="nav-item"><span>Ordens de Serviço</span></div>

            <!-- CATÁLOGO / SUBMENU -->
            <div class="nav-section-title">Catálogo</div>

            <div class="nav-item open" onclick="toggleSubmenu(this)">
                <span>Catálogo</span>
                <span class="arrow">▶</span>
            </div>

            <div class="submenu" style="max-height:500px;"> <!-- Mantém aberto -->
                <a href="catalogo_marcas.php">
                    <div class="submenu-item active">Catálogo de Marcas</div>
                </a>
                <a href="catalogo_categorias.php">
                    <div class="submenu-item">Catálogo de Categorias</div>
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

    <!-- ÁREA PRINCIPAL -->
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

            <button onclick="openPopup()"
                style="padding:8px 14px;background:#00c485;color:white;border:none;border-radius:6px;cursor:pointer;">
                + Nova Marca
            </button>

            <div class="table-wrapper" style="margin-top:20px;">
                <div class="table-title">Marcas Registradas</div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>País Origem</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($m = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $m['id'] ?></td>
                                <td><?= $m['nome'] ?></td>
                                <td><?= $m['pais_origem'] ?: "-" ?></td>
                                <td>
                                    <span class="action-link">Editar</span>
                                    <span class="action-link">Excluir</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <div>
        <!-- MODAL DE NOVA MARCA -->
        <div class="popup-overlay" id="popup">
            <div class="popup-content">

                <button class="close-btn" onclick="closePopup()">&times;</button>

                <h2>Cadastrar Nova Marca</h2>
                <p>Insira as informações da marca abaixo:</p>

                <form id="formMarcas" action="nova_marca.php" method="POST">

                    <!-- Preview opcional de imagem -->
                    <img id="preview" alt="Pré-visualização" style="display:none;"><br>

                    <label>URL do ícone da marca (opcional):</label>
                    <input type="text" name="icone" id="iconeUrl" placeholder="https://exemplo.com/logo.png"
                        oninput="previewIcon()">

                    <label>Nome da Marca:</label>
                    <input type="text" name="nome" required placeholder="Ex: Nivea, L'Oréal, Dove">

                    <label>Fabricante (opcional):</label>
                    <input type="text" name="fabricante" placeholder="Ex: Unilever, P&G, Boticário">

                    <label>País de Origem (opcional):</label>
                    <input type="text" name="pais_origem" placeholder="Ex: Brasil, EUA">

                    <label>Descrição (opcional):</label>
                    <textarea name="descricao" rows="4" placeholder="Informações sobre a marca..."
                        style="width:100%;padding:10px;border:1.5px solid #ccc;border-radius:6px;"></textarea>

                    <button class="save-btn" type="submit">Salvar Marca</button>
                </form>

            </div>
        </div>

        <!-- SCRIPT DO SUBMENU ANIMADO -->
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

            function openPopup() {
                document.getElementById("popup").style.display = "flex";
            }

            function closePopup() {
                document.getElementById("popup").style.display = "none";
            }

            function previewIcon() {
                const url = document.getElementById("iconeUrl").value;
                const preview = document.getElementById("preview");

                if (url.length > 5) {
                    preview.src = url;
                    preview.style.display = "block";
                } else {
                    preview.style.display = "none";
                }
            }
        </script>

</body>

</html>