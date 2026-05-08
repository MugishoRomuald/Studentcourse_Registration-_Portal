<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Only students can enrol (admins manage courses, not enrol in them)
if ($_SESSION['user']['role'] !== 'student') {
    header('Location: dashboard.php');
    exit;
}

include('db.php');

$userId   = (int)$_SESSION['user']['id'];
$courseId = (int)($_GET['id'] ?? 0);

if ($courseId <= 0) {
    header('Location: browse_courses.php');
    exit;
}

try {
    $stmt = $conn->prepare("INSERT IGNORE INTO registrations (user_id, course_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $courseId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'You have been enrolled in the course.'];
    } else {
        $_SESSION['flash'] = ['type' => 'info', 'message' => 'You are already enrolled in that course.'];
    }
} catch (mysqli_sql_exception $e) {
    error_log('Enrol error: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Enrolment failed. Please try again.'];
}

header('Location: enrolled.php');
exit;
