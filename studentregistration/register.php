
<?php
session_start();
include('db.php');

// for an admin to create an account, we implement a policy of him or her using a secret key
define('ADMIN_SECRET_KEY', 'mugisho');

$error = '';
$selectedRole = 'student';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $roleChoice = $_POST['role'] ?? 'student';
    $adminKey   = trim($_POST['admin_key'] ?? '');

    //This is our Validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($roleChoice === 'admin' && $adminKey !== ADMIN_SECRET_KEY) {
        $error = 'Invalid admin secret key.';
        $selectedRole = 'admin';
    } else {
        // Our system only allows admin and student and it will ignore other things
        $role = ($roleChoice === 'admin') ? 'admin' : 'student';

        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $hashed, $role);
            $stmt->execute();

            $_SESSION['flash'] = ['type' => 'success', 'message' => ucfirst($role) . ' account successfully created! Please log in.'];
            header('Location: login.php');
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($conn->errno === 1062) {
                $error = 'That email is already registered.';
            } else {
                error_log('Register error: ' . $e->getMessage());
                $error = 'A server error occurred. Please try again.';
            }
        }
    }
}

include('header.php');
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h3 class="mb-3" id="account">Create Account</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php" novalidate>
            <div class="mb-3">
                <label class="form-label"><strong>Full Name<strong></label>
                <input class="form-control" name="name" value="<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?>" required placeholder="Enter your full name e.g Mugisho Munganga">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required placeholder="Type your email here e.g mugishomunganga@gmail.com">
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Password</strong></label>
                <input class="form-control" type="password" name="password" minlength="8" required placeholder="Please enter your password here">
            </div>

            <!-- Role selection buttons -->
            <div class="mb-3">
                <label class="form-label">Register as</label>
                <div class="d-flex gap-2">
                    <input type="radio" class="btn-check" name="role" id="role_student" value="student"
                           <?= ($selectedRole === 'student') ? 'checked' : '' ?> onchange="toggleAdminKey(this)">
                    <label class="btn btn-outline-primary w-50" for="role_student">Student</label>

                    <input type="radio" class="btn-check" name="role" id="role_admin" value="admin"
                           <?= ($selectedRole === 'admin') ? 'checked' : '' ?> onchange="toggleAdminKey(this)">
                    <label class="btn btn-outline-danger w-50" for="role_admin">Admin</label>
                </div>
            </div>

            <!-- The admin secret key field is hidden by default -->
            <div class="mb-3" id="admin_key_field" style="display:<?= ($selectedRole === 'admin') ? 'block' : 'none' ?>;">
                <label class="form-label">Admin Secret Key</label>
                <input class="form-control" type="password" name="admin_key" placeholder="Please enter the admin secret key to continue">
                <div class="form-text text-muted">We only let authorised admins to have this key.</div>
            </div>

            <button class="btn btn-primary w-100">Create Account</button>
        </form>
        <p class="mt-3 text-center"><a href="login.php">Already have an account? Login</a></p>
    </div>
</div>

<script>
function toggleAdminKey(radio) {
    document.getElementById('admin_key_field').style.display =
        (radio.value === 'admin') ? 'block' : 'none';
}
</script>

<?php include('footer.php'); ?>
<link rel="stylesheet" href="styles.css">