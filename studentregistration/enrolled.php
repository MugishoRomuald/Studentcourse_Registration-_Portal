<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

include('db.php');
include('header.php');

$userId = (int)$_SESSION['user']['id'];

try {
    $stmt = $conn->prepare(
        "SELECT c.course_name, c.course_code, c.description, r.created_at AS enrolled_on
         FROM registrations r
         JOIN courses c ON c.id = r.course_id
         WHERE r.user_id = ?
         ORDER BY c.course_name ASC"
    );
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();
} catch (mysqli_sql_exception $e) {
    error_log('My courses error: ' . $e->getMessage());
    $res = null;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>My Enrolled Courses</h3>
    <a href="browse_courses.php" class="btn btn-outline-primary btn-sm">Browse More</a>
</div>

<?php 
if (!$res || $res->num_rows === 0): ?>
    <p class="text-muted">You haven't enrolled in any courses yet.
        <a href="browse_courses.php">Browse available courses.</a>
    </p>
<?php else: ?>
    <div class="row g-3">
        <?php 
        while ($row = $res->fetch_assoc()): ?>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8') ?></h5>
                        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($row['course_code'], ENT_QUOTES, 'UTF-8') ?></span>
                        <p class="card-text text-muted small"><?= htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div class="card-footer text-muted small">
                        Enrolled: <?= htmlspecialchars(date('d M Y', strtotime($row['enrolled_on'])), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php include('footer.php'); ?>
