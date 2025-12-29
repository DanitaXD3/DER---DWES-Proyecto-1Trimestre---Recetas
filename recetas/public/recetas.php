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

$pdo = new PDO(
    'mysql:host=db;dbname=recetas;charset=utf8',
    'root',
    'root'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receta_id'])) {
    $stmt = $pdo->prepare('INSERT INTO recetas_usuario (usuario_id, receta_id) VALUES (?, ?)');
    $stmt->execute([
        $_SESSION['usuario']['id'],
        $_POST['receta_id']
    ]);

    header('Location: /public/miperfil.php');
    exit;
}

$pais_filtro = $_GET['pais'] ?? '';

$stmtPaises = $pdo->query('SELECT DISTINCT pais_origen FROM recetas');
$paises_disponibles = $stmtPaises->fetchAll(PDO::FETCH_COLUMN);

$query = '
    SELECT r.* 
    FROM recetas r
    WHERE r.id NOT IN (
        SELECT receta_id FROM recetas_usuario WHERE usuario_id = ?
    )';
$params = [$_SESSION['usuario']['id']];

if ($pais_filtro) {
    $query .= ' AND r.pais_origen = ?';
    $params[] = $pais_filtro;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo $twig->render('recetas.html.twig', [
    'usuario' => $_SESSION['usuario'],
    'recetas' => $recetas,
    'paises_disponibles' => $paises_disponibles,
    'pais_filtro' => $pais_filtro
]);
