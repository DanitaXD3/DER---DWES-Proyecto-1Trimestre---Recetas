<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

session_start();

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, ['cache' => false]);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = new PDO('mysql:host=db;dbname=recetas;charset=utf8', 'root', 'root');
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $_POST['password'] === $user['password']) {
        $_SESSION['usuario'] = $user;
        header('Location: /public/miperfil.php');
        exit;
    }

    $error = 'El email o la contraseña no son correctas';
}

echo $twig->render('login.html.twig', [
    'error' => $error,
    'usuario' => $_SESSION['usuario'] ?? null
]);
