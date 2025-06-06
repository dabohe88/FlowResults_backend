<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
require_once(__DIR__ . '/../db.php');

$sql = "SELECT codigo, nombre, imagen FROM pais";

try {
    $stmt = $pdo->query($sql);
    $paises = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($paises, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
?>
