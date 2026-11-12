<?php
/**
 * Contact / Quote Form Submission Handler
 */

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/auth.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $service = trim($_POST['service'] ?? 'General Inquiry');
    $message = trim($_POST['message'] ?? '');
    $redirect = $_POST['redirect'] ?? 'contact.php';

    // Simple anti-spam honeypot check
    if (!empty($_POST['website_url_hp'])) {
        header("Location: index.php");
        exit;
    }

    if (empty($name) || empty($email) || empty($message)) {
        setFlash('danger', 'Please provide your name, valid email, and project details.');
        header("Location: " . $redirect . "#quote-form");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash('danger', 'Please enter a valid email address.');
        header("Location: " . $redirect . "#quote-form");
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, service, message, status) VALUES (?, ?, ?, ?, ?, 'unread')");
        $stmt->execute([$name, $email, $phone, $service, $message]);

        setFlash('success', 'Thank you! Your inquiry has been received. Our senior project engineer will contact you within 24 hours.');
        header("Location: " . $redirect . "#quote-form");
        exit;
    } catch (PDOException $e) {
        setFlash('danger', 'An error occurred while submitting your inquiry. Please call us directly.');
        header("Location: " . $redirect . "#quote-form");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
