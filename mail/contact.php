<?php
// Basic input validation
if (empty($_POST['name']) || 
    empty($_POST['subject']) || 
    empty($_POST['message']) || 
    !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // Bad request
    exit("Invalid input.");
}


// Sanitize inputs
$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Email setup
$to = "jaykipkerich@gmail.com"; // Your email address
$subject = "$m_subject: $name";
$body = "You have received a new message from your website contact form.\n\n" .
        "Details:\n\nName: $name\nEmail: $email\nSubject: $m_subject\n\nMessage:\n$message";
$headers = "From: noreply@stairwaytech.org\r\n"; // Use a domain-based email
$headers .= "Reply-To: $email\r\n";

if (!mail($to, $subject, $body, $headers)) {
    error_log("Mail failed to send to $to with subject $subject");
    http_response_code(500);
    exit("Error: Unable to send email.");
}

// Respond with success
http_response_code(200);
echo "Email sent successfully.";



?>
