<?php
$host = 'localhost'; $db = 'uuemoisa_miil'; $user = 'miiluser'; $pass = 'miilparool';
$conn = new mysqli($host, $user, $pass, $db);

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM registreerumised WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header("Location: andmed.php");
exit;

