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
    <title>Casita Bakery - Dashboard</title>
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

        .welcome {
            margin: 20px auto;
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        nav {
            margin: 20px auto;
            width: 90%;
            max-width: 800px;
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

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 30px auto;
            max-width: 900px;
        }

        .card {
            flex: 1 1 200px;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .card h2 {
            font-size: 36px;
            color: #2575fc;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            color: #555;
        }

    </style>
</head>
<body>
    <header>
        <h1>Casita Bakery</h1>
    </header>

    <div class="welcome">
        Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?>
    </div>

    <nav>
        <ul>
            <li><a href="clientes/listarClientes.php">Listar Clientes</a></li>
            <li><a href="productos/listarProductos.php">Listar Productos</a></li>
            <li><a href="pedidos/listarPedidos.php">Listar Pedidos</a></li>
            <li><a href=#>Listar Usuarios</a></li>
            <li><a href="usuarios/logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>

    <div class="cards-container">
        <div class="card">
            <h2>120</h2>
            <p>Clientes registrados</p>
        </div>
        <div class="card">
            <h2>80</h2>
            <p>Productos disponibles</p>
        </div>
        <div class="card">
            <h2>45</h2>
            <p>Pedidos activos</p>
        </div>
        <div class="card">
            <h2>5</h2>
            <p>Pedidos pendientes de entrega</p>
        </div>
    </div>
</body>
</html>
