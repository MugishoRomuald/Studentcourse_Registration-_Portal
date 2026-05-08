<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include('db.php');
include('header.php');

$res = $conn->query("SELECT * FROM courses ORDER BY course_name ASC");
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manage Courses</h3>
    <a href="add_course.php" class="btn btn-success">+ Add Course</a>
</div>

<?php if ($res->num_rows === 0): ?>
    <p class="text-muted">No courses yet. Add one above.</p>
<?php else: ?>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Course Name</th>
                <th>Code</th>
                <th>Description</th>
                <th style="width:160px">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($row['course_name'], ENT_QUOTES, 'UTF-8') ?>
                        </td>
                    <td><?= htmlspecialchars($row['course_code'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <!-- DELETE uses a POST form to prevent accidental/bot deletion -->
                        <form method="POST" action="delete.php" class="d-inline"
                              onsubmit="return confirm('Delete this course?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ??= bin2hex(random_bytes(32)), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include('footer.php'); ?>
