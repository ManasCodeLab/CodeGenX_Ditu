<?php
// Must be first - start session
session_start();

// Force HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
}

// CORS Configuration
header("Access-Control-Allow-Origin: https://codegenx-ditu.vercel.app");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Handle CSRF token request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo json_encode(['csrf_token' => $_SESSION['csrf_token']]);
    exit;
}

// Load PHPMailer
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = parse_ini_file('.env');
$smtpUser = $dotenv['SMTP_USER'];
$smtpPass = $dotenv['SMTP_PASS'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON input for AJAX requests
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate CSRF token
    if (!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        exit(json_encode(['success' => false, 'message' => 'Invalid CSRF token']));
    }

    // Sanitize inputs
    $name = filter_var($input['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($input['message'], FILTER_SANITIZE_STRING);

    // Validate inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($message)) $errors[] = 'Message is required';

    if (!empty($errors)) {
        http_response_code(400);
        exit(json_encode(['success' => false, 'message' => implode(', ', $errors)]));
    }

    try {
        $mail = new PHPMailer(true);

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Admin Email
        $mail->setFrom($smtpUser, 'CodeGenX');
        $mail->addAddress($smtpUser);
        $mail->addAddress($email);
        $mail->addReplyTo($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "New Contact: $name";
        $mail->Body = "
            <img src='https://raw.githubusercontent.com/ManasCodeLab/CodeGenX/main/assets/logo.png' style='height: 80px'>
            <h2>New Message</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        // Send admin email
        $mail->send();

        // Send user confirmation
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = "Thank you for contacting CodeGenX!";
        $mail->Body = "
            <img src='https://raw.githubusercontent.com/ManasCodeLab/CodeGenX/main/assets/logo.png' style='height: 80px'>
            <h2>Thank you for contacting us!</h2>
            <p>We've received your message and will respond shortly.</p>
            <p><strong>Your Message:</strong></p>
            <p>$message</p>
        ";
        $mail->send();

        // Regenerate CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
    } catch (Exception $e) {
        error_log('Mail Error: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to send message. Please try again.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}