<?php
$host = 'localhost'; $db = 'uuemoisa_miil'; $user = 'miiluser'; $pass = 'miilparool';
$conn = new mysqli($host, $user, $pass, $db);

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM registreerumised WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Muuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>Muuda võistleja andmeid</h2>

<form action="salvestamuutus.php" method="post">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <div class="mb-3">
        <label>Eesnimi</label>
        <input type="text" name="eesnimi" class="form-control" value="<?= htmlspecialchars($data['eesnimi']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Perenimi</label>
        <input type="text" name="perenimi" class="form-control" value="<?= htmlspecialchars($data['perenimi']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Võistlusklass</label>
        <input type="text" name="võistlusklass" class="form-control" value="<?= htmlspecialchars($data['võistlusklass']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['email']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Salvesta</button>
    <a href="andmed.php" class="btn btn-secondary">Tagasi</a>
</form>
</body>
</html>

