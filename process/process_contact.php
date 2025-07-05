<?php
// Ensure this script is only accessible via POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Set recipients' email addresses
    $to = "contact@assistanceconseiling.com";
    // Uncomment the line below if you also want to send a copy to stevetchingang@yahoo.com
    $to .= ", stevetchingang@yahoo.com"; // Add a comma before the second email if sending to multiple

    // Sanitize and validate input data
    // Using FILTER_SANITIZE_EMAIL and FILTER_VALIDATE_EMAIL for email for better security
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject'] ?? '')); // Added subject field
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Tous les champs du formulaire sont requis."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "L'adresse email n'est pas valide."]);
        exit;
    }

    // Email subject for the recipient
    $email_subject = "Nouveau message de contact via ACI Website: " . $subject;

    // Email body
    $email_body = "Vous avez reçu un nouveau message de contact depuis votre site web ACI.\n\n";
    $email_body .= "Nom: " . $name . "\n";
    $email_body .= "Email: " . $email . "\n";
    $email_body .= "Sujet: " . $subject . "\n";
    $email_body .= "Message:\n" . $message . "\n";

    // Email headers
    $headers = "From: " . $email . "\r\n"; // Sender's email
    $headers .= "Reply-To: " . $email . "\r\n"; // Reply to sender
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n"; // Ensure proper character encoding

    // Attempt to send the email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo json_encode(["status" => "success", "message" => "Votre message a été envoyé avec succès ! Nous vous répondrons bientôt."]);
    } else {
        // Log the error for debugging (e.g., to a file or system logs)
        error_log("Failed to send email from " . $email . ". Mail function returned false.");
        echo json_encode(["status" => "error", "message" => "Désolé, une erreur est survenue lors de l'envoi de votre message. Veuillez réessayer plus tard ou nous contacter directement."]);
    }

} else {
    // If someone tries to access the PHP script directly, redirect or show an error
    header("Location: /"); // Redirect to home page
    exit;
}
?>