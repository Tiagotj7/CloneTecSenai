<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require __DIR__ . '/../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name         = trim($_POST['name'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $registration = trim($_POST['registration'] ?? '');
    $course       = trim($_POST['course'] ?? '');

    if ($name === '' || $email === '' || $registration === '' || $course === '') {
        $error = 'Preencha todos os campos.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (name, email, registration, course) 
                                   VALUES (:name, :email, :registration, :course)");
            $stmt->execute([
                'name'         => $name,
                'email'        => $email,
                'registration' => $registration,
                'course'       => $course,
            ]);

            header('Location: list.php');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // unique constraint
                $error = 'E-mail ou matrícula já cadastrados.';
            } else {
                $error = 'Erro ao salvar: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Create Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="body-dashboard">

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
            <h1 class="page-title">Novo aluno</h1>
            <p class="page-subtitle">Cadastre um novo aluno no sistema.</p>

            <div class="card">
                <?php if ($error): ?>
                    <div class="alert alert-error" style="margin-bottom:12px;"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="name">Nome completo</label>
                        <input type="text" id="name" name="name" required
                               style="width:100%; padding:8px; border-radius:8px; border:1px solid #d1d5db;">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" required
                               style="width:100%; padding:8px; border-radius:8px; border:1px solid #d1d5db;">
                    </div>

                    <div class="form-group">
                        <label for="registration">Matrícula</label>
                        <input type="text" id="registration" name="registration" required
                               style="width:100%; padding:8px; border-radius:8px; border:1px solid #d1d5db;">
                    </div>

                    <div class="form-group">
                        <label for="course">Curso</label>
                        <input type="text" id="course" name="course" required
                               style="width:100%; padding:8px; border-radius:8px; border:1px solid #d1d5db;">
                    </div>

                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="list.php" style="margin-left:8px;">Cancelar</a>
                </form>
            </div>
        </section>
    </main>

</body>
</html>