<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Student Portal - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- CSS principal -->
    <link rel="stylesheet" href="assets/css/style.css">

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }
    </script>
</head>
<body class="body-dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">SENAI PORTAL</div>
        </div>

        <nav class="sidebar-menu">
            <div class="sidebar-section-title">Geral</div>
            <a href="dashboard.php"><span class="icon">🏠</span>Início</a>
            <a href="#"><span class="icon">📌</span>Mural</a>
            <a href="#"><span class="icon">📅</span>Calendário</a>
            <a href="#"><span class="icon">📚</span>Grade Curricular</a>
            <a href="#"><span class="icon">📝</span>Matrícula online</a>

            <div class="sidebar-section-title">Central do Aluno</div>
            <a href="#"><span class="icon">✅</span>Faltas</a>
            <a href="#"><span class="icon">📈</span>Notas</a>
            <a href="#"><span class="icon">📄</span>Histórico</a>
            <a href="#"><span class="icon">📘</span>Plano de aula</a>

            <div class="sidebar-section-title">Serviços</div>
            <a href="#"><span class="icon">💼</span>Oportunidades</a>
            <a href="#"><span class="icon">💰</span>Financeiro</a>
            <a href="#"><span class="icon">📎</span>Arquivos</a>

            <div class="sidebar-section-title">Administração</div>
            <a href="students/list.php"><span class="icon">👨‍🎓</span>Alunos</a>
        </nav>

        <div class="sidebar-footer">
            Logado como<br>
            <strong><?php echo htmlspecialchars($name); ?></strong><br>
            <span style="font-size:11px; opacity:0.8;"><?php echo strtoupper($role); ?></span>
        </div>
    </aside>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="main-content">
        <header class="topbar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
            <div class="topbar-user">
                Olá, <span><?php echo htmlspecialchars($name); ?></span>
            </div>
            <div class="topbar-actions">
                <a href="logout.php">Sair</a>
            </div>
        </header>

        <section class="page-content">
            <h1 class="page-title">Bem-vindo ao Portal do Aluno</h1>
            <p class="page-subtitle">
                Acompanhe sua vida acadêmica: notas, frequência, calendário e muito mais.
            </p>

            <!-- CARDS RESUMO -->
            <div class="cards-grid">
                <div class="card">
                    <div class="card-title">Próxima aula</div>
                    <div class="card-value">Hoje, 19h - Lógica de Programação</div>
                    <div class="card-tag card-tag-blue">Sala 204 · Bloco B</div>
                </div>

                <div class="card">
                    <div class="card-title">Média geral</div>
                    <div class="card-value">8,7</div>
                    <div class="card-tag card-tag-green">Semestre 2025.1</div>
                </div>

                <div class="card">
                    <div class="card-title">Frequência</div>
                    <div class="card-value">95%</div>
                    <div class="card-tag card-tag-green">Situação regular</div>
                </div>
            </div>

            <!-- ÁREA DE CONTEÚDO EXTRA (exemplo) -->
            <div class="card">
                <h2 style="font-size:16px; margin-bottom:8px;">Avisos recentes</h2>
                <ul style="font-size:14px; color:#4b5563; padding-left:18px; line-height:1.6;">
                    <li>Prazo para renovação de matrícula até 30/06.</li>
                    <li>Semana de integração com palestras e workshops.</li>
                    <li>Atualize seus dados cadastrais no setor acadêmico.</li>
                </ul>
            </div>

        </section>
    </main>

</body>
</html>