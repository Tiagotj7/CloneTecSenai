<?php
// register.php
session_start();
require __DIR__ . '/config/database.php';

// Se já estiver logado, manda para o dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($name === '' || $username === '' || $email === '' || $password === '' || $confirm === '') {
        $error = 'Preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'E-mail inválido.';
    } elseif ($password !== $confirm) {
        $error = 'As senhas não conferem.';
    } elseif (strlen($password) < 6) {
        $error = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        try {
            // Verificar se username OU email já existem
            $check = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1');
            $check->execute([
                'username' => $username,
                'email'    => $email,
            ]);

            if ($check->fetch()) {
                $error = 'Usuário ou e-mail já cadastrados.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    'INSERT INTO users (name, username, email, password, role)
                     VALUES (:name, :username, :email, :password, :role)'
                );
                $stmt->execute([
                    'name'     => $name,
                    'username' => $username,
                    'email'    => $email,
                    'password' => $hash,
                    'role'     => 'student',
                ]);

                // login automático após cadastro
                $id = $pdo->lastInsertId();
                $_SESSION['user_id']   = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_role'] = 'student';

                header('Location: dashboard.php');
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Student Portal - Register</title>
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

            <h1 class="login-title">Criar conta</h1>
            <p class="login-subtitle">Cadastre-se para acessar o portal do aluno.</p>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="post" class="login-form">
                <div class="form-group">
                    <label for="name">Nome completo</label>
                    <div class="input-icon">
                        <span class="icon">👤</span>
                        <input type="text" id="name" name="name" required
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Usuário</label>
                    <div class="input-icon">
                        <span class="icon">📛</span>
                        <input type="text" id="username" name="username" required
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <div class="input-icon">
                        <span class="icon">@</span>
                        <input type="email" id="email" name="email" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="input-icon">
                        <span class="icon">🔒</span>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar senha</label>
                    <div class="input-icon">
                        <span class="icon">🔒</span>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Registrar</button>

                <div class="login-links">
                    <a href="index.php">Já tem conta? Faça login</a>
                </div>
            </form>

            <footer class="login-footer">
                © <?php echo date('Y'); ?> SENAI - Portal do Aluno
            </footer>
        </div>
    </div>
</body>
</html>