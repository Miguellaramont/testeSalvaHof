<?php
session_start();
require "../config.php";
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
    <?php include "../Dashboard/sidebar.php"; ?>

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
                    <div class="card-value">
                        <?php
                        $stmt = $mysqli->query('SELECT COUNT(*) AS total_users FROM users');
                        if ($stmt) {
                            $row = $stmt->fetch_assoc();
                            $totalUsers = $row['total_users'] ?? 0;
                            echo $totalUsers;
                        } else {
                            echo '0';
                        }
                        ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-title">Novos hoje</div>
                    <div class="card-value">0</div>
                </div>
                <div class="card">
                    <div class="card-title">Admins</div>
                    <div class="card-value">1</div>
                </div>
            </div>

            <div class="table-wrapper">
                <div class="table-title">Últimos Usuários</div>

                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th tyle="width:80px;">Ações</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Exemplo: buscar os 10 últimos usuários
                        $sql = "SELECT nome, email FROM users ORDER BY id DESC LIMIT 10";
                        $result = $mysqli->query($sql);

                        if ($result && $result->num_rows > 0):
                            while ($user = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['nome']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <span class="action-link">
                                            Excluir
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            endwhile;
                        else:
                            ?>
                            <tr>
                                <td colspan="4">Nenhum usuário encontrado.</td>
                            </tr>
                        <?php endif; ?>
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