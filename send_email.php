<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

// Capturar datos con limpieza básica
$nombre   = htmlspecialchars(trim($_POST['nombre'] ?? ''));
$email    = htmlspecialchars(trim($_POST['email'] ?? ''));
$telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
$asunto   = htmlspecialchars(trim($_POST['asunto'] ?? 'Sin asunto'));
$mensaje  = htmlspecialchars(trim($_POST['mensaje'] ?? ''));

// Validación
if (empty($nombre) || empty($email) || empty($mensaje)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, completa los campos obligatorios.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ganamex.oficial@gmail.com';
    $mail->Password   = 'cxbv ysni ctua ljnk'; // Verifica que esta contraseña sea válida
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';
    $mail->Timeout    = 30; // Tiempo de espera aumentado

    // Configuración de remitente y destinatario
    $mail->setFrom('ganamex.oficial@gmail.com', 'GANAMEX Web');
    $mail->addAddress('ganamex.oficial@gmail.com', 'Administrador');
    $mail->addReplyTo($email, $nombre);

    // Contenido del mensaje
    $mail->isHTML(true);
    $mail->Subject = "Nuevo mensaje desde GANAMEX - $asunto";
    $mail->Body = "
        <h2>Nuevo mensaje desde el sitio web</h2>
        <p><strong>Nombre:</strong> {$nombre}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Teléfono:</strong> {$telefono}</p>
        <p><strong>Asunto:</strong> {$asunto}</p>
        <p><strong>Mensaje:</strong><br>" . nl2br($mensaje) . "</p>
    ";

    // Intento de envío
    if(!$mail->send()) {
        throw new Exception('Error al enviar el correo: ' . $mail->ErrorInfo);
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true, 
        'message' => 'Ya se enviaron tus datos. Te contactaremos pronto. Serás redirigido en 3 segundos...',
        'redirect' => 'http://localhost/GANAMEX/', // CAMBIA ESTA URL POR TU DOMINIO REAL
        'redirectDelay' => 3000
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error al procesar tu solicitud: ' . $e->getMessage()
    ]);
}

