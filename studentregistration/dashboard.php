<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include('db.php');
include('header.php');

// Quick stats for the admin
$totalCourses = $conn->query("SELECT COUNT(*) AS c FROM courses")->fetch_assoc()['c'];
$totalStudents = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role='student'")->fetch_assoc()['c'];
$totalEnrolments = $conn->query("SELECT COUNT(*) AS c FROM registrations")->fetch_assoc()['c'];
?>

<h3 class="mb-4">Admin Dashboard</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center p-3">
            <h2 class="text-primary"><?= (int)$totalCourses ?></h2>
            <p class="text-muted mb-0">Courses</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3">
            <h2 class="text-success"><?= (int)$totalStudents ?></h2>
            <p class="text-muted mb-0">Students</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3">
            <h2 class="text-warning"><?= (int)$totalEnrolments ?></h2>
            <p class="text-muted mb-0">Enrolments</p>
        </div>
    </div>
</div>

<a href="courses.php" class="btn btn-primary">Manage Courses</a>

<?php include('footer.php'); ?>
