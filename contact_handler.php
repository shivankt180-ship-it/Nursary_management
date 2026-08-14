<?php
// Basic contact form handler - appends messages to messages.txt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Simple validation
    if ($name === '' || $email === '' || $message === '') {
        header('Location: p1.html?sent=0#contact');
        exit;
    }

    // Sanitize values for storage
    $safe_name = strip_tags($name);
    $safe_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $safe_subject = strip_tags($subject);
    $safe_message = strip_tags($message);

    $entry = date('Y-m-d H:i:s') . "\t" . $safe_name . "\t" . $safe_email . "\t" . $safe_subject . "\t" . $safe_message . PHP_EOL;

    $file = __DIR__ . DIRECTORY_SEPARATOR . 'messages.txt';
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

    header('Location: p1.html?sent=1#contact');
    exit;
}

// If accessed directly, redirect back
header('Location: p1.html');
exit;
