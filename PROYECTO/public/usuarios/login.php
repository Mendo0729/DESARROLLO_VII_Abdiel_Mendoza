<?php
session_start();
require_once __DIR__ . '/../../src/controllers/LoginController.php';


$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);

if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Mi App</title>
   <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #6a11cb, #2575fc);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        width: 350px;
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 25px;
        color: #333;
        font-weight: 600;
    }

    .login-container label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
        color: #555;
        font-size: 14px;
    }

    .login-container input {
        width: 100%;
        padding: 10px 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .login-container input:focus {
        border-color: #2575fc;
        box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
        outline: none;
    }

    .login-container button {
        width: 100%;
        padding: 12px;
        background: #2575fc;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .login-container button:hover {
        background: #1a5ad1;
    }

    .error {
        color: #ff4d4d;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .login-container p {
        font-size: 14px;
        color: #777;
        margin-top: 10px;
    }
</style>

</head>
<body>
<div class="login-container">
    <h2>Iniciar Sesión</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login_process.php" method="post">
        <label>Usuario:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
</div>
</body>
</html>
