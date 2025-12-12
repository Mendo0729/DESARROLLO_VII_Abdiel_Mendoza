<?php
session_start();
require_once __DIR__ . '/../../src/controllers/LoginController.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = loginUsuario($username, $password);

    if ($result['success']) {
        header('Location: ../dashboard.php');
        exit;
    } else {
        $_SESSION['login_error'] = $result['message'];
        header('Location: login.php');
        exit;
    }
}
