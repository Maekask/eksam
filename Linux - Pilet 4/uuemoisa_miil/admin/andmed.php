<?php
$host = 'localhost';
$db = 'uuemoisa_miil';
$user = 'miiluser';
$pass = 'miilparool';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Ühendus ebaõnnestus: " . $conn->connect_error);

// Filtreerimine
$filter = $_GET['klass'] ?? '';
$stmt = $filter ? 
    $conn->prepare("SELECT * FROM registreerumised WHERE võistlusklass = ?") : 
    $conn->prepare("SELECT * FROM registreerumised");

if ($filter) $stmt->bind_param('s', $filter);
$stmt->execute();
$result = $stmt->get_result();

// Statistika
$stat = $conn->query("SELECT COUNT(*) AS kokku, võistlusklass, COUNT(*) AS arv FROM registreerumised GROUP BY võistlusklass");
$kokku = $conn->query("SELECT COUNT(*) AS arv FROM registreerumised")->fetch_assoc()['arv'];
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin - Uuemõisa Miil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>Administreerimisliides</h2>

<!-- Statistika -->
<div class="mb-4">
    <h4>Statistika</h4>
    <p><strong>Kokku registreerunuid:</strong> <?= $kokku ?></p>
    <ul>
    <?php while ($r = $stat->fetch_assoc()): ?>
        <li><strong><?= htmlspecialchars($r['võistlusklass']) ?>:</strong> <?= $r['arv'] ?></li>
    <?php endwhile; ?>
    </ul>
</div>

<!-- Filtreerimine -->
<form method="get" class="mb-4">
    <label for="klass" class="form-label">Filtreeri võistlusklassi järgi:</label>
    <input type="text" name="klass" id="klass" class="form-control w-25 d-inline" value="<?= htmlspecialchars($filter) ?>">
    <button class="btn btn-primary">Filtreeri</button>
    <a href="andmed.php" class="btn btn-secondary">Tühjenda filter</a>
</form>

<!-- Tabel -->
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Eesnimi</th>
            <th>Perenimi</th>
            <th>Võistlusklass</th>
            <th>Email</th>
            <th>Tegevused</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['eesnimi']) ?></td>
            <td><?= htmlspecialchars($row['perenimi']) ?></td>
            <td><?= htmlspecialchars($row['võistlusklass']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="muuda.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Muuda</a>
                <a href="kustuta.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Kustutada?')">Kustuta</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="logout.php" class="btn btn-secondary mt-4">Logi välja</a>
</body>
</html>

