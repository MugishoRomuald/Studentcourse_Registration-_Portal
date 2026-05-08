<?php
session_start();

// If User is already logged in, he or she will be redirected
if (isset($_SESSION['user'])) {
    header('Location: ' . ($_SESSION['user']['role'] === 'admin' ? 'dashboard.php' : 'studentdashboard.php'));
    exit;
}

include('db.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Our Basic validation starts here
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
            // It will prevent us from SQL Injection
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                // We used this to prevent session fixation
                session_regenerate_id(true);
                $_SESSION['user'] = $user;

                $redirect = ($user['role'] === 'admin') ? 'dashboard.php' : 'studentdashboard.php';
                header("Location: $redirect");
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (mysqli_sql_exception $e) {
            error_log('Login error: ' . $e->getMessage());
            $error = 'A server error occurred. Please try again.';
        }
    }
}

include('header.php');
?>

<div class="row justify-content-center">
    <div class="col-md-4">
        <h3 class="mb-3">Login</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; 
?>
<form method="POST" action="login.php" novalidate>
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ??= bin2hex(random_bytes(32)), ENT_QUOTES, 'UTF-8') ?>">
<div class="mb-3">
<label class="form-label">Email</label>
                <input class="form-control" type="email" name="email"value="<?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') ?>" required placeholder="Enter Your Email Here">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input class="form-control" type="password" name="password" required placeholder="Type Your Password Here">
            </div>
            <button class="btn btn-primary w-100" id="login">Login</button>
        </form>
        <p class="mt-3 text-center"><a href="register.php">Don't have an account? Register</a></p>
        <button onclick="back()" class="back-btn">Go Back</button>
    </div>
</div>

<?php include('footer.php'); ?>
<style>

.back-btn{
    background-color:blue;
    color:white;
    border:none;
    padding:5px 40px;
    font-size:18px;
    border-radius:6px;
    cursor:pointer;

}

.back-btn:hover{
    background-color:green;
}
 body{
        background-color: lightblue;

</style>
<script>
    function back(){
    window.location="index.php";
}
</script>
