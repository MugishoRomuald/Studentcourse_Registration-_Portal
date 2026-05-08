<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Only allow POST — no deletions via a URL link
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: courses.php');
    exit;
}

// CSRF check
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token.');
}

include('db.php');

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    try {
        $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Course deleted.'];
    } catch (mysqli_sql_exception $e) {
        error_log('Delete error: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Could not delete course.'];
    }
}

header('Location: courses.php');
exit;
