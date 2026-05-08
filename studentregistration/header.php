<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Umoja Student Course Registration Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="login.php">Umoja Student Course Registration Portal</a>
        <img src="download.png" alt="Logo" style="width: 150px; height: 75px; border-radius: 5%;">
        <?php if (isset($_SESSION['user'])): ?>
            <span class="text-white me-3">
                Hello, <?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?>
            </span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Flash message display -->
<?php if (isset($_SESSION['flash'])): ?>
    <div class="container mt-2">
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type'], ENT_QUOTES, 'UTF-8') ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['flash']['message'], ENT_QUOTES, 'UTF-8') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="container mt-4">
