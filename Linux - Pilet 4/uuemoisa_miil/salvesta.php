<?php
session_start();

$host = 'localhost';
$db = 'uuemoisa_miil';
$user = 'miiluser';
$pass = 'miilparool';

// Ühenda andmebaasiga
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Andmebaasi ühendus ebaõnnestus: " . $conn->connect_error);
}

// Sisendandmete puhastamine ja valideerimine
$eesnimi = trim($_POST['eesnimi'] ?? '');
$perenimi = trim($_POST['perenimi'] ?? '');
$voistlusklass = trim($_POST['voistlusklass'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($eesnimi === '' || $perenimi === '' || $voistlusklass === '' || $email === '') {
    $_SESSION['message'] = 'Kõik väljad peavad olema täidetud.';
    header('Location: index.php?page=avaleht');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = 'Palun sisesta korrektne e-mail.';
    header('Location: index.php?page=avaleht');
    exit;
}

// Kontrolli, kas email on juba olemas
$stmt = $conn->prepare("SELECT id FROM registreerumised WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['message'] = 'Sellise e-mailiga inimene on juba registreeritud.';
    $stmt->close();
    $conn->close();
    header('Location: index.php?page=avaleht');
    exit;
}
$stmt->close();

// Lisa uus registreeruja
$stmt = $conn->prepare("INSERT INTO registreerumised (eesnimi, perenimi, võistlusklass, email) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $eesnimi, $perenimi, $voistlusklass, $email);
if ($stmt->execute()) {
    $_SESSION['message'] = 'Registreerimine õnnestus!';
} else {
    $_SESSION['message'] = 'Viga registreerimisel.';
}
$stmt->close();
$conn->close();

header('Location: index.php?page=avaleht');
exit;

