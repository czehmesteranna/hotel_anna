<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Hozzáférés megtagadva.");
}

if (!isset($_GET['id'])) {
    die("Hiányzó azonosító.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_anna";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM foglalasok WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin.php");
    exit();
} else {
    echo "Hiba a törlés során: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
