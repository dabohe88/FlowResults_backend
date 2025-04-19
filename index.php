<?php
require_once __DIR__ . '/db.php';

echo "<h1>Bienvenido al backend de Flow Results</h1>";

try {
    // Solo prueba la conexión
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<p>Conexión a la base de datos establecida correctamente.</p>";
    echo "<p>Tablas encontradas:</p><ul>";
    foreach ($tables as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Error al conectar con la base de datos: " . $e->getMessage() . "</p>";
}
?>
