<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Student Portal - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-body">
    <div class="login-bg"></div>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">
                <span class="logo-text">SENAI<span class="logo-highlight">Portal</span></span>
            </div>

            <h1 class="login-title">Portal do Aluno</h1>
            <p class="login-subtitle">Acesse suas informações acadêmicas de forma rápida e segura.</p>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    Usuário ou senha inválidos.
                </div>
            <?php endif; ?>

            <form action="auth.php" method="post" class="login-form">
                <div class="form-group">
                    <label for="username">Usuário</label>
                    <div class="input-icon">
                        <span class="icon">👤</span>
                        <input type="text" id="username" name="username" required autocomplete="username">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="input-icon">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Acessar</button>

                <div class="login-links">
                    <a href="#">Esqueceu sua senha?</a>
                </div>
            </form>

            <div class="login-links">
                <a href="register.php">Não tem conta? Registre-se</a>
            </div>

            <footer class="login-footer">
                © <?php echo date('Y'); ?> SENAI - Portal do Aluno
            </footer>
        </div>
    </div>
</body>

</html>