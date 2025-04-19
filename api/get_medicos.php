<?php
// Encabezados para permitir acceso desde el frontend (CORS)
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Conexión con la base de datos
require_once('../db.php');

// Consulta SQL para obtener médicos con relaciones a especialidades, clínicas y procedimientos
$sql = "
SELECT
  m.id,
  m.nombre,
  m.imagen,
  m.email,
  m.telefono,
  GROUP_CONCAT(DISTINCT e.nombre) AS especialidades,
  GROUP_CONCAT(DISTINCT c.nombre) AS clinicas,
  GROUP_CONCAT(DISTINCT p.nombre) AS procedimientos
FROM medico m
LEFT JOIN medico_especialidad me ON m.id = me.medico_id
LEFT JOIN especialidad e ON me.especialidad_id = e.id
LEFT JOIN medico_clinica mc ON m.id = mc.medico_id
LEFT JOIN clinica c ON mc.clinica_id = c.id
LEFT JOIN medico_procedimiento mp ON m.id = mp.medico_id
LEFT JOIN procedimiento p ON mp.procedimiento_id = p.id
GROUP BY m.id
ORDER BY m.id
";

$result = $conn->query($sql);

$medicos = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $medicos[] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'imagen' => $row['imagen'],
        'email' => $row['email'],
        'telefono' => $row['telefono'],
        'especialidades' => explode(',', $row['especialidades']),
        'clinicas' => explode(',', $row['clinicas']),
        'procedimientos' => explode(',', $row['procedimientos']),
    ];
}

echo json_encode($medicos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
