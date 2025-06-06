<?php
// Dirección a la que se enviará el cuestionario
$receiving_email_address = 'hgranados@flowresults.com';

// Solo aceptar POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Captura y limpia todos los campos
  $objetivos = $_POST['objetivos'] ?? [];
  $servicios = $_POST['servicios'] ?? [];
  $sitio_web = $_POST['sitio_web'] ?? '';
  $dificultades = $_POST['dificultades'] ?? [];
  $frecuencia = $_POST['frecuencia'] ?? '';
  $canales = $_POST['canales'] ?? [];
  $gestion_redes = $_POST['gestion_redes'] ?? '';

  $nombre = trim($_POST['nombre'] ?? '');
  $especialidad = trim($_POST['especialidad'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $telefono = trim($_POST['telefono'] ?? '');
  $pais = trim($_POST['pais'] ?? '');
  $centro = trim($_POST['centro_medico'] ?? '');

  // Validación mínima
  if (empty($nombre) || empty($especialidad) || empty($email) || empty($telefono) || empty($pais) || empty($centro)) {
    http_response_code(400);
    echo "Por favor complete todos los campos obligatorios.";
    exit;
  }

  // Armado del mensaje
  $mensaje = "🩺 FORMULARIO CUESTIONARIO MÉDICO\n\n";
  $mensaje .= "🔹 Objetivo principal:\n" . implode(", ", $objetivos) . "\n\n";
  $mensaje .= "🔹 Servicios de interés:\n" . implode(", ", $servicios) . "\n\n";
  $mensaje .= "🔹 ¿Tiene sitio web?: $sitio_web\n\n";
  $mensaje .= "🔹 Dificultades actuales:\n" . implode(", ", $dificultades) . "\n\n";
  $mensaje .= "🔹 Frecuencia de publicaciones: $frecuencia\n";
  $mensaje .= "🔹 Canales activos:\n" . implode(", ", $canales) . "\n";
  $mensaje .= "🔹 ¿Gestión de redes?: $gestion_redes\n\n";
  $mensaje .= "📇 DATOS DE CONTACTO\n";
  $mensaje .= "Nombre: $nombre\nEspecialidad: $especialidad\nEmail: $email\nTeléfono: $telefono\nPaís: $pais\nCentro médico: $centro\n";

  // Envío
  $asunto = "Cuestionario Médico - Flow Results";
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";

  if (mail($receiving_email_address, $asunto, $mensaje, $headers)) {
    http_response_code(200);
    echo "Formulario enviado correctamente. Gracias.";
  } else {
    http_response_code(500);
    echo "Hubo un error al enviar el cuestionario.";
  }

} else {
  http_response_code(403);
  echo "Método no permitido.";
}
?>
