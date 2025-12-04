<?php
session_start();
/*
if (empty($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
*/
$nome = $_SESSION['user_nome'] ?? 'Usuário';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<title>Painel - Salva Hof</title>
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
        <a href="dashboard.php">
            <div class="nav-item active"><span>Painel de Controle</span></div>
        </a>

        <div class="nav-item no-link"><span>Relatórios</span></div>
        <div class="nav-item no-link"><span>Extravio</span></div>
        <div class="nav-item no-link"><span>Vendas</span></div>

        <!-- GERENCIAMENTO -->
        <div class="nav-section-title">Gerenciamento</div>
        <div class="nav-item no-link"><span>Usuários</span></div>
        <div class="nav-item no-link"><span>Aplicativo</span></div>
        <div class="nav-item no-link"><span>Notificações</span></div>
        <div class="nav-item no-link"><span>Reposição</span></div>
        <div class="nav-item no-link"><span>Ordens de Serviço</span></div>

        <!-- CATÁLOGO / SUBMENU -->
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
        <div>Logado como: <br><strong><?= htmlspecialchars($nome) ?></strong></div>
        <div style="margin-top:6px;">
            <a href="../logout.php" style="color:#fff;text-decoration:none;">Sair</a>
        </div>
    </div>
</div>


<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div>Painel de Controle</div>
        <div class="topbar-right">
            <span><?= htmlspecialchars($nome) ?></span>
            <div class="avatar"></div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <h1>Visão Geral</h1>

        <div class="cards">
            <div class="card">
                <div class="card-title">Usuários ativos</div>
                <div class="card-value">42</div>
            </div>
            <div class="card">
                <div class="card-title">Novos hoje</div>
                <div class="card-value">3</div>
            </div>
            <div class="card">
                <div class="card-title">Admins</div>
                <div class="card-value">5</div>
            </div>
        </div>

        <div class="table-wrapper">
            <div class="table-title">Últimos Usuários</div>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width:80px;">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Davi Rocha Souza Lima</td>
                        <td>davi@salvahof.com</td>
                        <td><span class="badge">User</span></td>
                        <td><span class="action-link">Excluir</span></td>
                    </tr>
                    <tr>
                        <td>Hércules Ferreira Brandão</td>
                        <td>hercules@salvahof.com</td>
                        <td><span class="badge">Admin</span></td>
                        <td><span class="action-link">Excluir</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- SCRIPT DO SUBMENU -->
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

</body>
</html>
