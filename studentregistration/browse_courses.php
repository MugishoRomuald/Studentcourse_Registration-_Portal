<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

include('db.php');
include('header.php');

$search = trim($_GET['search'] ?? '');
$userId = (int)$_SESSION['user']['id'];

try {
    // Prepared statement with LIKE — wildcard added in PHP, not in SQL string
    $like = '%' . $search . '%';
    $stmt = $conn->prepare(
        "SELECT c.*, 
                (SELECT COUNT(*) FROM registrations r WHERE r.user_id=? AND r.course_id=c.id) AS enrolled
         FROM courses c
         WHERE c.course_name LIKE ? OR c.course_code LIKE ?
         ORDER BY c.course_name ASC"
    );
    $stmt->bind_param("iss", $userId, $like, $like);
    $stmt->execute();
    $res = $stmt->get_result();
} catch (mysqli_sql_exception $e) {
    error_log('Browse courses error: ' . $e->getMessage());
    $res = null;
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Browse Courses</h3>
</div>

<form method="GET" action="browse_courses.php" class="mb-3 d-flex gap-2">
    <input name="search" class="form-control" placeholder="Search by name or code"
           value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
    <button class="btn btn-outline-primary">Search</button>
    <?php if ($search): ?>
        <a href="browse_courses.php" class="btn btn-outline-secondary">Clear</a>
    <?php endif; ?>
</form>

<?php if (!$res || $res->num_rows === 0): ?>
    <p class="text-muted">No courses found.</p>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Course Name</th>
                <th>Code</th>
                <th>Description</th>
                <th style="width:120px">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['course_code'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?php if ($row['enrolled']): ?>
                            <span class="badge bg-success">Enrolled</span>
                        <?php else: ?>
                            <a href="enroll.php?id=<?= (int)$row['id'] ?>" class="btn btn-success btn-sm">Enroll</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include('footer.php'); ?>
