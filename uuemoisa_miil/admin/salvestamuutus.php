<?php
$host = 'localhost'; $db = 'uuemoisa_miil'; $user = 'miiluser'; $pass = 'miilparool';
$conn = new mysqli($host, $user, $pass, $db);

$id = intval($_POST['id']);
$eesnimi = trim($_POST['eesnimi']);
$perenimi = trim($_POST['perenimi']);
$klass = trim($_POST['võistlusklass']);
$email = trim($_POST['email']);

$stmt = $conn->prepare("UPDATE registreerumised SET eesnimi=?, perenimi=?, võistlusklass=?, email=? WHERE id=?");
$stmt->bind_param('ssssi', $eesnimi, $perenimi, $klass, $email, $id);
$stmt->execute();

header("Location: andmed.php");
exit;

