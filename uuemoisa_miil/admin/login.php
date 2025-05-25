<?php
session_start();

// Määra siin administraatori kasutajanimi ja parool
$admin_user = 'admin';
$admin_pass = 'salaparool'; // muuda see!

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Vale kasutajanimi või parool!';
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin sisselogimine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Administraatori sisselogimine</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="username" class="form-label">Kasutajanimi</label>
            <input type="text" class="form-control" id="username" name="username" required />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Parool</label>
            <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Logi sisse</button>
    </form>
</div>
</body>
</html>

