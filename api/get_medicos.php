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
  m.enlace_cita,
  m.pais AS pais_codigo,
  pa.nombre AS pais_nombre,
  pa.bandera AS pais_bandera,
  c.nombre AS clinica,
  e.nombre AS especialidad,
  a.nombre AS area,
  p.nombre AS procedimiento
FROM medico m
LEFT JOIN pais pa ON m.pais = pa.codigo
LEFT JOIN medico_especialidad me ON m.id = me.medico_id
LEFT JOIN especialidad e ON me.especialidad_id = e.id
LEFT JOIN area a ON e.area_id = a.id
LEFT JOIN medico_clinica mc ON m.id = mc.medico_id
LEFT JOIN clinica c ON mc.clinica_id = c.id
LEFT JOIN medico_procedimiento mp ON m.id = mp.medico_id
LEFT JOIN procedimiento p ON mp.procedimiento_id = p.id
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
                if (!in_array($row['especialidad'], $medico['especialidades']) && $row['especialidad']) {
                    $medico['especialidades'][] = $row['especialidad'];
                }
                if (!in_array($row['procedimiento'], $medico['procedimientos']) && $row['procedimiento']) {
                    $medico['procedimientos'][] = $row['procedimiento'];
                }
                $found = true;
                break;
            }
        }

        if (!$found) {
            $output[$area][] = [
                'id' => $medico_id,
                'nombre' => $row['medico_nombre'],
                'pais_codigo' => $row['pais_codigo'],
                'pais_nombre' => $row['pais_nombre'],
                'bandera' => $row['pais_bandera'],
                'imagen' => $row['imagen'],
                'email' => $row['email'],
                'contacto' => $row['contacto'],
                'clinica' => $row['clinica'] ?? '',
                'especialidades' => $row['especialidad'] ? [$row['especialidad']] : [],
                'procedimientos' => $row['procedimiento'] ? [$row['procedimiento']] : [],
                'enlace_cita' => $row['enlace_cita'] ?? ''
            ];
        }
    }

    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
?>
