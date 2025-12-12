<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

// Incluir el controller
require_once __DIR__ . '/../../src/controllers/ProductosController.php';

$controller = new ProductoController();
$productos = $controller->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
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
            max-width: 1000px;
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

        .btn-red {
            background: #ff4d4d;
        }

        .btn-red:hover {
            background: #e60000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table thead {
            background: #2575fc;
            color: #fff;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        table tr:hover {
            background: #f1f5ff;
        }

        a {
            text-decoration: none;
        }

        .action-btns a {
            margin-right: 5px;
        }

    </style>
</head>
<body>
    <header>
        <h1>Productos</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    </header>

    <div class="container">
        <a href="../dashboard.php" class="btn">Volver al Dashboard</a>
        <a href="crearProducto.php" class="btn" style="margin-left:10px;">Agregar Producto</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Activo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto->id) ?></td>
                        <td><?= htmlspecialchars($producto->nombre) ?></td>
                        <td>$<?= number_format($producto->precio, 2) ?></td>
                        <td><?= $producto->activo ? 'Sí' : 'No' ?></td>
                        <td><?= htmlspecialchars($producto->descripcion) ?></td>
                        <td class="action-btns">
                            <a href="verProducto.php?id=<?= $producto->id ?>" class="btn">Ver</a>
                            <a href="editarProducto.php?id=<?= $producto->id ?>" class="btn">Editar</a>
                            <a href="eliminarProducto.php?id=<?= $producto->id ?>" class="btn btn-red" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

