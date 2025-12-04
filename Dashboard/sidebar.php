<?php
if (!isset($_SESSION)) {
    session_start();
}

$nome = $_SESSION['user_nome'] ?? "Usuário";
?>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="sidebar-header">
        Salva Hof<br>
        <span style="font-size:11px;font-weight:400;">Seu varejista</span>
    </div>

    <div class="sidebar-nav">

        <!-- PRINCIPAL -->
        <a href="../Dashboard/dashboard.php">
            <div class="nav-item">
                <span>Painel de Controle</span>
            </div>
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

        <!-- CATÁLOGO -->
        <div class="nav-section-title">Catálogo</div>

        <div class="nav-item" onclick="toggleSubmenu(this)">
            <span>Catálogo</span>
            <span class="arrow">▶</span>
        </div>

        <div class="submenu">
            <a href="../Catalogos/catalogo_marcas.php">
                <div class="submenu-item">Catálogo de Marcas</div>
            </a>

            <a href="../Catalogos/catalogo_categorias.php">
                <div class="submenu-item">Catálogo de Categorias</div>
            </a>

        </div>

    </div>

    <div class="sidebar-footer">
        <div>
            Logado como:<br>
            <strong><?= htmlspecialchars($nome) ?></strong>
        </div>

        <div style="margin-top:6px;">
            <a href="../logout.php" style="color:#fff;text-decoration:none;">Sair</a>
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
</script>
