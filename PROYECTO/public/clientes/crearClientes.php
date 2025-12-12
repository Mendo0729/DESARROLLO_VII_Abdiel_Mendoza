<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ClienteController.php';

$mensaje = '';
$nombre = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $controller = new ClienteController();
    $cliente = $controller->crear(['nombre' => $nombre]);

    if ($cliente) {
        $mensaje = "Cliente '$nombre' creado exitosamente.";
        $nombre = ''; 
    } else {
        $mensaje = "Error: no se pudo crear el cliente. Tal vez ya existe o el nombre es inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cliente</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f8;
            color: #333;
        }

        header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            padding: 20px 40px;
            text-align: center;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .container {
            width: 90%;
            max-width: 500px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .container p {
            margin-bottom: 15px;
            color: #555;
        }

        .btn {
            padding: 10px 20px;
            background: #2575fc;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #1a5ad1;
            transform: translateY(-2px);
        }

        input[type="text"] {
            width: 100%;
            padding: 10px 15px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #2575fc;
            box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
            outline: none;
        }

        .mensaje {
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .mensaje-exito {
            background-color: #d4edda;
            color: #155724;
        }

        .mensaje-error {
            background-color: #f8d7da;
            color: #721c24;
        }

    </style>
</head>
<body>
    <header>
        <h1>Crear Cliente</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    </header>

    <div class="container">
        <a href="listarClientes.php" class="btn">Volver a la lista de clientes</a>

        <?php if ($mensaje): ?>
            <div class="mensaje <?= strpos($mensaje, 'Error') !== false ? 'mensaje-error' : 'mensaje-exito' ?>">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="nombre">Nombre del Cliente:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
            <br><br>
            <button type="submit" class="btn">Crear Cliente</button>
        </form>
    </div>
</body>
</html>
