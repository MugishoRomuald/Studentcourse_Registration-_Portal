<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

include('db.php');
include('header.php');

$userId = (int)$_SESSION['user']['id'];
$enrolCount = $conn->prepare("SELECT COUNT(*) AS c FROM registrations WHERE user_id=?");
$enrolCount->bind_param("i", $userId);
$enrolCount->execute();
$count = $enrolCount->get_result()->fetch_assoc()['c'];
?>

<h3 class="mb-3">Welcome, <?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?>!</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-center p-3">
            <h2 class="text-primary"><?= (int)$count ?></h2>
            <p class="text-muted mb-0">Courses enrolled</p>
        </div>
    </div>
</div>

<a href="browse_courses.php" class="btn btn-primary me-2">Browse Courses</a>
<a href="enrolled.php" class="btn btn-secondary">My Enrolled Courses</a>

<?php include('footer.php'); ?>
