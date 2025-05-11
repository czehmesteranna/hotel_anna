<?php
session_start();

$conn = new mysqli("localhost", "root", "", "hotel_anna");
if ($conn->connect_error) {
    die("Hiba: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT jelszo_hash FROM adminok WHERE felhasznalonev = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($hash);
if ($stmt->fetch()) {
    if (password_verify($password, $hash)) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        echo "Hibás jelszó.";
    }
} else {
    echo "Admin nem található.";
}
$stmt->close();
$conn->close();
?>
