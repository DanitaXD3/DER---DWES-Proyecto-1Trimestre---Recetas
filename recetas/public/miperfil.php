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

// === Eliminar receta del perfil si se hace POST ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receta_id'])) {
    $stmt = $pdo->prepare('DELETE FROM recetas_usuario WHERE usuario_id = ? AND receta_id = ?');
    $stmt->execute([
        $_SESSION['usuario']['id'],
        $_POST['receta_id']
    ]);
    header('Location: /public/miperfil.php');
    exit;
}

// === Obtener recetas del usuario según filtro ===
$pais_seleccionado = $_GET['pais'] ?? null;

if ($pais_seleccionado) {
    $stmt = $pdo->prepare(
        'SELECT r.*
         FROM recetas r
         INNER JOIN recetas_usuario ru ON r.id = ru.receta_id
         WHERE ru.usuario_id = ? AND r.pais_origen = ?'
    );
    $stmt->execute([$_SESSION['usuario']['id'], $pais_seleccionado]);
} else {
    $stmt = $pdo->prepare(
        'SELECT r.*
         FROM recetas r
         INNER JOIN recetas_usuario ru ON r.id = ru.receta_id
         WHERE ru.usuario_id = ?'
    );
    $stmt->execute([$_SESSION['usuario']['id']]);
}

$recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// === Obtener lista de países únicos de las recetas del usuario para el desplegable ===
$stmt = $pdo->prepare(
    'SELECT DISTINCT r.pais_origen
     FROM recetas r
     INNER JOIN recetas_usuario ru ON r.id = ru.receta_id
     WHERE ru.usuario_id = ?'
);
$stmt->execute([$_SESSION['usuario']['id']]);
$paises = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo $twig->render('miperfil.html.twig', [
    'usuario' => $_SESSION['usuario'],
    'recetas' => $recetas,
    'paises' => $paises,
    'pais_seleccionado' => $pais_seleccionado
]);
