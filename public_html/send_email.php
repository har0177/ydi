<?php
/**
 * Contact Form Email Handler - DRY/KISS Approach
 */
require_once "config.php";
require_once "inc/loader.php";
require_once "inc/csrf.php";

// Configuration
$admin_email = 'info@ydi.edu.pk';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['bcheck']) || $_POST['bcheck'] !== 'true') {
    header('HTTP/1.1 400 Bad Request');
    exit('Invalid request');
}

// CSRF Protection
if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
    header('HTTP/1.1 403 Forbidden');
    exit('Security token expired');
}

// Get form data
$is_enquiry = isset($_POST['is_enquiry']) && $_POST['is_enquiry'] === '1';

$name    = htmlspecialchars(trim($_POST['name'] ?? ''));
$email   = trim($_POST['email'] ?? '');
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

if ($is_enquiry) {
    $phone   = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $service = htmlspecialchars(trim($_POST['service'] ?? ''));
    $subject = 'YDI Enquiry: ' . ($service !== '' ? $service : 'Service Enquiry');
} else {
    $phone   = '';
    $service = '';
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
}

// Validate
// Common required fields
if (empty($name) || empty($email) || empty($message)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Please fill in all required fields');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Invalid email address');
}

if ($is_enquiry) {
    if (empty($phone) || empty($service)) {
        header('HTTP/1.1 400 Bad Request');
        exit('Please fill in all required fields');
    }
    if (!preg_match('/^[0-9 +\-()]{6,32}$/', $phone)) {
        header('HTTP/1.1 400 Bad Request');
        exit('Invalid phone number');
    }
} else {
    if (empty($subject)) {
        header('HTTP/1.1 400 Bad Request');
        exit('Please fill in all required fields');
    }
}

// Save to database
$post_date = date("Y-m-d H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];

try {
    $db = new database();
    $db->runQuery(
        "INSERT INTO tblcontact (title, name, short_description, email, phone, service, status, post_date, ip) VALUES (?, ?, ?, ?, ?, ?, 0, ?, ?)",
        [
            cleanString($subject),
            cleanString($name),
            cleanString($message),
            $email,
            $is_enquiry ? cleanString($phone) : null,
            $is_enquiry ? cleanString($service) : null,
            $post_date,
            $ip,
        ]
    );
} catch (PDOException $e) {
    // Continue even if DB save fails — email is the user-facing path
}

// Send email to admin
if ($is_enquiry) {
    $email_body  = "New service enquiry from the YDI website:\n\n";
    $email_body .= "Service: $service\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Phone: $phone\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Date: $post_date\n";
    $email_body .= "IP: $ip\n\n";
    $email_body .= "Message:\n$message\n";
} else {
    $email_body  = "New contact form submission:\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n";
    $email_body .= "Date: $post_date\n";
    $email_body .= "IP: $ip\n\n";
    $email_body .= "Message:\n$message\n";
}

$headers = "From: YDI Website <$admin_email>\r\n";
$headers .= "Reply-To: $name <$email>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Try to send email (suppress errors - DB save is backup)
@mail($admin_email, "YDI Contact: $subject", $email_body, $headers);

// Send confirmation to user
if ($is_enquiry) {
    $user_body  = "Dear $name,\n\n";
    $user_body .= "Thank you for contacting us. Our customer service team will get back to you soon.\n\n";
    $user_body .= "Your enquiry:\n";
    $user_body .= "Service: $service\n";
    $user_body .= "$message\n\n";
    $user_body .= "Best regards,\n";
    $user_body .= "YDI Team\n";
    $user_body .= "www.ydi.edu.pk";

    $user_subject = 'Thank you for your enquiry - YDI';
} else {
    $user_body  = "Dear $name,\n\n";
    $user_body .= "Thank you for contacting Youth Development Institute, Swat.\n\n";
    $user_body .= "We have received your message and will get back to you shortly.\n\n";
    $user_body .= "Your message:\n";
    $user_body .= "Subject: $subject\n";
    $user_body .= "$message\n\n";
    $user_body .= "Best regards,\n";
    $user_body .= "YDI Team\n";
    $user_body .= "www.ydi.edu.pk";

    $user_subject = 'Thank you for contacting YDI';
}

$user_headers = "From: YDI Swat <$admin_email>\r\n";
$user_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

@mail($email, $user_subject, $user_body, $user_headers);

// Success response
header('HTTP/1.1 200 OK');
echo 'Message sent successfully';
