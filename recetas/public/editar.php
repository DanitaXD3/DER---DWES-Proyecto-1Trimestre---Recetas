<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /public/login.php');
    exit;
}

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader, ['cache' => false]);

$pdo = new PDO('mysql:host=db;dbname=recetas;charset=utf8', 'root', 'root');

// === Actualizar la receta solo si vienen todos los campos por POST ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['receta_id']) 
    && isset($_POST['nombre'], $_POST['pais_origen'], $_POST['descripcion'], $_POST['estrellas'])) {
    
    $stmt = $pdo->prepare('UPDATE recetas SET nombre = ?, pais_origen = ?, descripcion = ?, estrellas = ? WHERE id = ?');
    $stmt->execute([
        $_POST['nombre'],
        $_POST['pais_origen'],
        $_POST['descripcion'],
        $_POST['estrellas'],
        $_POST['receta_id']
    ]);

    header('Location: /public/miperfil.php');
    exit;
}

// === Cargar datos de la receta si viene por GET ===
$receta_id = $_GET['receta_id'] ?? null;
$receta = null;

if ($receta_id) {
    $stmt = $pdo->prepare('SELECT * FROM recetas WHERE id = ?');
    $stmt->execute([$receta_id]);
    $receta = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Si no hay receta, mostrar mensaje
if (!$receta && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo $twig->render('editar.html.twig', [
        'usuario' => $_SESSION['usuario'],
        'receta' => null
    ]);
    exit;
}

// Renderizar formulario
echo $twig->render('editar.html.twig', [
    'usuario' => $_SESSION['usuario'],
    'receta' => $receta
]);
