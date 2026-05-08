<?php
session_start();

// This is our authentication and user role check
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include('db.php');
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
            $stmt = $conn->prepare("INSERT INTO courses (course_name, course_code, description) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $code, $desc);
            $stmt->execute();

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Course added successfully.'];
            header('Location: courses.php');
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($conn->errno === 1062) {
                $error = 'A course with that code already exists.';
            } else {
                error_log('Add course error: ' . $e->getMessage());
                $error = 'A server error occurred. Please try again.';
            }
        }
    }
}

// Generate CSRF token if not set
$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

include('header.php');
?>

<h3 class="mb-3">Add New Course</h3>
<div class="row">
    <div class="col-md-6">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <form method="POST" action="add_course.php">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input name="name" class="form-control" value="<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Course Code</label>
                <input name="code" class="form-control" value="<?= htmlspecialchars($code ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="desc" class="form-control" rows="4"><?= htmlspecialchars($desc ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <a href="courses.php" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-primary">Save Course</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
