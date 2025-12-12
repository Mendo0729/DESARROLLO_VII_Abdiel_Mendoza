<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mi ERP</title>
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        nav {
            margin: 30px auto;
            width: 90%;
            max-width: 600px;
            text-align: center;
        }

        nav ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        nav ul li {
            flex: 1 1 40%;
        }

        nav ul li a {
            display: block;
            padding: 15px;
            background: #2575fc;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        nav ul li a:hover {
            background: #1a5ad1;
            transform: translateY(-3px);
        }

        main {
            margin: 20px auto;
            width: 90%;
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }

        main p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></h1>

    <nav>
        <ul>
            <li><a href="clientes/listarClientes.php">Listar Clientes</a></li>
            <li><a href="productos/listarProductos.php">Listar Productos</a></li>
            <li><a href="pedidos/listarPedidos.php">Listar Pedidos</a></li>
            <li><a href="usuarios/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>

    <p>Selecciona una opción del menú para continuar.</p>
</body>
</html>
