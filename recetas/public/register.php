<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, ['cache' => false]);

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['password'] !== $_POST['password_repeat']) {
        $error = 'La contraseña no coincide.';
    } else {
        $pdo = new PDO('mysql:host=db;dbname=recetas;charset=utf8', 'root', 'root');

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$_POST['email']]);
        $userExist = $stmt->fetch();

        if ($userExist) {
            $error = 'Este usuario ya existe';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO usuarios (email, password) VALUES (?, ?)'
            );

            $stmt->execute([
                $_POST['email'],
                $_POST['password'] 
            ]);

            header('Location: ../public/login.php');
            exit;
        }
    }
}

echo $twig->render('register.html.twig', [
    'error' => $error
]);
