<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $error = "Por favor, completa los campos obligatorios.";
        header("Location: index.html?status=error&message=" . urlencode($error));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingresa un correo electrónico válido.";
        header("Location: index.html?status=error&message=" . urlencode($error));
        exit;
    }

    // Prepare email
    $to = "info@dpautoelevadores.com";
    $subject = "Nuevo mensaje de contacto desde dp autoelevadores";
    $body = "Nombre: $name\n";
    $body .= "Email: $email\n";
    $body .= "Teléfono: $phone\n";
    $body .= "Mensaje:\n$message";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        $success = "Mensaje enviado con éxito. ¡Gracias por contactarnos!";
        header("Location: index.html?status=success&message=" . urlencode($success));
    } else {
        $error = "Hubo un error al enviar el mensaje. Por favor, intenta de nuevo.";
        header("Location: index.html?status=error&message=" . urlencode($error));
    }
} else {
    // Redirect to homepage if accessed directly
    header("Location: index.html");
}
exit;
?>