<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require __DIR__ . '/../config/database.php';

// Buscar todos os alunos
$stmt = $pdo->query("SELECT * FROM students ORDER BY created_at DESC");
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Students - List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="body-dashboard">

    <!-- Sidebar reutilizando o estilo do dashboard -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">SENAI PORTAL</div>
        </div>

        <nav class="sidebar-menu">
            <div class="sidebar-section-title">Geral</div>
            <a href="../dashboard.php"><span class="icon">🏠</span>Início</a>

            <div class="sidebar-section-title">Administração</div>
            <a href="list.php"><span class="icon">👨‍🎓</span>Alunos</a>
        </nav>

        <div class="sidebar-footer">
            Logado como<br>
            <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong><br>
            <span style="font-size:11px; opacity:0.8;"><?php echo strtoupper($_SESSION['user_role']); ?></span>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button class="sidebar-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')">☰</button>
            <div class="topbar-user">
                Olá, <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            </div>
            <div class="topbar-actions">
                <a href="../logout.php">Sair</a>
            </div>
        </header>

        <section class="page-content">
            <h1 class="page-title">Alunos</h1>
            <p class="page-subtitle">Gerencie os alunos cadastrados no sistema.</p>

            <div style="margin-bottom: 16px;">
                <a href="create.php" class="btn btn-primary">+ Novo aluno</a>
            </div>

            <div class="card">
                <table style="width:100%; border-collapse: collapse; font-size: 14px;">
                    <thead>
                        <tr style="background:#f3f4f6;">
                            <th style="text-align:left; padding:8px;">Nome</th>
                            <th style="text-align:left; padding:8px;">E-mail</th>
                            <th style="text-align:left; padding:8px;">Matrícula</th>
                            <th style="text-align:left; padding:8px;">Curso</th>
                            <th style="text-align:left; padding:8px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) === 0): ?>
                            <tr>
                                <td colspan="5" style="padding:10px; text-align:center; color:#6b7280;">
                                    Nenhum aluno cadastrado.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $student): ?>
                                <tr style="border-top:1px solid #e5e7eb;">
                                    <td style="padding:8px;"><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td style="padding:8px;"><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td style="padding:8px;"><?php echo htmlspecialchars($student['registration']); ?></td>
                                    <td style="padding:8px;"><?php echo htmlspecialchars($student['course']); ?></td>
                                    <td style="padding:8px;">
                                        <a href="edit.php?id=<?php echo $student['id']; ?>" style="margin-right:8px;">Editar</a>
                                        <a href="delete.php?id=<?php echo $student['id']; ?>"
                                           onclick="return confirm('Deseja realmente excluir este aluno?');"
                                        >Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

</body>
</html>