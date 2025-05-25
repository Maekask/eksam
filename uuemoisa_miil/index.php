<?php
session_start();
?>

<!DOCTYPE html>
<html lang="et">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Uuemõisa Miil 2025</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Bänner -->
<header class="bg-primary text-white text-center py-4 mb-4">
<div class="container">
<img src="banner.jpg" alt="Uuemõisa Miil 2025" class="img-fluid mb-2" style="max-height: 200px;">
<h1>Uuemõisa Miil 2025</h1>
</div>
</header>

<!-- Menüü -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
<div class="container">
<a class="navbar-brand" href="#">Uuemõisa Miil</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="menuNav">
    <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="?page=avaleht">Avaleht</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=galerii">Galerii</a></li>
        <li class="nav-item"><a class="nav-link" href="?page=kontakt">Kontakt</a></li>
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-warning" href="admin/login.php">Admin</a>
        </li>
    </ul>
</div>
</div>
</nav>

<div class="container">

<?php
$page = $_GET['page'] ?? 'avaleht';

if ($page === 'avaleht') {
    include 'avaleht.php';
} elseif ($page === 'galerii') {
    include 'galerii.php';
} elseif ($page === 'kontakt') {
    include 'kontakt.php';
} else {
    echo "<h2>Lehte ei leitud</h2>";
}
?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

