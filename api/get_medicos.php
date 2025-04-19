<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

require_once(__DIR__ . '/../db.php');

$sql = "
SELECT
  m.id AS medico_id,
  m.nombre AS medico_nombre,
  m.imagen,
  m.email,
  m.contacto,
  e.nombre AS especialidad,
  a.nombre AS area
FROM medico m
LEFT JOIN medico_especialidad me ON m.id = me.medico_id
LEFT JOIN especialidad e ON me.especialidad_id = e.id
LEFT JOIN area a ON e.area_id = a.id
ORDER BY a.nombre, m.nombre
";

try {
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = [];

    foreach ($result as $row) {
        $area = $row['area'] ?? 'Otras';
        $medico_id = $row['medico_id'];

        if (!isset($output[$area])) {
            $output[$area] = [];
        }

        $found = false;
        foreach ($output[$area] as &$medico) {
            if ($medico['id'] === $medico_id) {
                if (!in_array($row['especialidad'], $medico['especialidades'])) {
                    $medico['especialidades'][] = $row['especialidad'];
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $output[$area][] = [
                'id' => $medico_id,
                'nombre' => $row['medico_nombre'],
                'imagen' => $row['imagen'],
                'email' => $row['email'],
                'contacto' => $row['contacto'],
                'especialidades' => $row['especialidad'] ? [$row['especialidad']] : [],
				'descripcion' => $row['especialidad'] ?? ''  // Aquí usamos la especialidad principal como descripción
            ];
        }
    }

    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
?>
