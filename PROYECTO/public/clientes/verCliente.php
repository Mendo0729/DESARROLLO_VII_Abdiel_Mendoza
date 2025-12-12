<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/ClienteController.php';

$controller = new ClienteController();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID de cliente inválido.");
}


$cliente = $controller->obtenerPorId((int)$id);
if (!$cliente) {
    die("Cliente no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles del Cliente</title>
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
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 25px 30px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #2575fc;
            color: #fff;
            width: 35%;
        }

        table td {
            background: #f9f9f9;
        }

    </style>
</head>
<body>
    <header>
        <h1>Detalles del Cliente</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    </header>

    <div class="container">
        <a href="listarClientes.php" class="btn">Volver a la lista de clientes</a>

        <table>
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($cliente->id) ?></td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td><?= htmlspecialchars($cliente->nombre) ?></td>
            </tr>
            <tr>
                <th>Activo</th>
                <td><?= $cliente->activo ? 'Sí' : 'No' ?></td>
            </tr>
            <tr>
                <th>Fecha de Registro</th>
                <td><?= htmlspecialchars($cliente->fecha_registro) ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
