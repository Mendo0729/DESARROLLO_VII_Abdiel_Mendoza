<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

require_once __DIR__ . '/../../src/controllers/PedidoController.php';
require_once __DIR__ . '/../../src/models/Clientes.php';

$controller = new PedidoController();
$pedidos = $controller->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
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
            width: 95%;
            max-width: 1200px;
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
        <h1>Pedidos</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></p>
    </header>

    <div class="container">
        <a href="../dashboard.php" class="btn">Volver al Dashboard</a>
        <a href="crearPedido.php" class="btn" style="margin-left:10px;">Crear Pedido</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha Pedido</th>
                    <th>Fecha Entrega</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= $pedido->id ?></td>
                        <td>
                            <?php
                            $cliente = new Cliente();
                            $stmt = (new PDO("mysql:host=localhost;dbname=mi_erp_db;charset=utf8", "root", ""))->prepare("SELECT nombre FROM clientes WHERE id = ?");
                            $stmt->execute([$pedido->cliente_id]);
                            $cliente_nombre = $stmt->fetchColumn();
                            echo htmlspecialchars($cliente_nombre);
                            ?>
                        </td>
                        <td><?= htmlspecialchars($pedido->fecha_pedido) ?></td>
                        <td><?= htmlspecialchars($pedido->fecha_entrega ?? '-') ?></td>
                        <td><?= htmlspecialchars($pedido->estado) ?></td>
                        <td>$<?= number_format($pedido->total ?? 0, 2) ?></td>
                        <td class="action-btns">
                            <a href="verPedido.php?id=<?= $pedido->id ?>" class="btn">Ver</a>
                            <a href="editarPedido.php?id=<?= $pedido->id ?>" class="btn">Editar</a>
                            <a href="eliminarPedido.php?id=<?= $pedido->id ?>" class="btn btn-red" onclick="return confirm('¿Eliminar este pedido?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
