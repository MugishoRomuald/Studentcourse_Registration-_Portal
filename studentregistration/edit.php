<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include('db.php');

// Cast to int to prevent SQL injection even before prepared stmt
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: courses.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $name = trim($_POST['name'] ?? '');
    $code = trim($_POST['code'] ?? '');
    $desc = trim($_POST['desc'] ?? '');

    if (empty($name) || empty($code)) {
        $error = 'Course name and code are required.';
    } else {
        try {
            $stmt = $conn->prepare("UPDATE courses SET course_name=?, course_code=?, description=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $code, $desc, $id);
            $stmt->execute();

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Course updated successfully.'];
            header('Location: courses.php');
            exit;
        } catch (mysqli_sql_exception $e) {
            error_log('Edit course error: ' . $e->getMessage());
            $error = 'A server error occurred. Please try again.';
        }
    }
}

// Fetch current course data
try {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
} catch (mysqli_sql_exception $e) {
    error_log('Fetch course error: ' . $e->getMessage());
    $row = null;
}

if (!$row) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Course not found.'];
    header('Location: courses.php');
    exit;
}

$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

include('header.php');
?>

<h3 class="mb-3">Edit Course</h3>
<div class="row">
    <div class="col-md-6">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <form method="POST" action="edit.php?id=<?= $id ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input name="name" class="form-control"
                       value="<?= htmlspecialchars($name ?? $row['course_name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Course Code</label>
                <input name="code" class="form-control"
                       value="<?= htmlspecialchars($code ?? $row['course_code'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="desc" class="form-control" rows="4"><?= htmlspecialchars($desc ?? $row['description'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <a href="courses.php" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-primary">Update Course</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
