<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_anna";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}


$nev = trim($_POST['nev']);
$email = trim($_POST['email']);
$szobatipus = $_POST['szobatipus'];
$vendegszam = (int)$_POST['vendegszam'];
$erkezes = $_POST['erkezes'];
$tavozas = $_POST['tavozas'];

if (empty($nev) || empty($email) || empty($szobatipus) || empty($erkezes) || empty($tavozas)) {
    die("Kérlek, tölts ki minden mezőt!");
}

if ($tavozas <= $erkezes) {
    die("A távozás dátumának későbbinek kell lennie, mint az érkezésének!");
}

$sql = "SELECT COUNT(*) as foglalasok_szama 
        FROM foglalasok 
        WHERE szobatipus = ? 
          AND (
            (erkezes_datum <= ? AND tavozas_datum > ?) OR 
            (erkezes_datum < ? AND tavozas_datum >= ?) OR 
            (erkezes_datum >= ? AND tavozas_datum <= ?)
          )";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $szobatipus, $erkezes, $erkezes, $tavozas, $tavozas, $erkezes, $tavozas);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$foglalt_szobak = $row['foglalasok_szama'];
$max_szobak = [
    "classic" => 10,
    "terasz" => 5,
    "csaladi" => 3,
    "lakosztaly" => 2
];

if ($foglalt_szobak >= $max_szobak[$szobatipus]) {
    die("Sajnáljuk, nincs elérhető szoba ebből a típusból az adott időszakban.");
}
$stmt = $conn->prepare("INSERT INTO foglalasok (nev, email, szobatipus, vendegszam, erkezes_datum, tavozas_datum) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $nev, $email, $szobatipus, $vendegszam, $erkezes, $tavozas);

if ($stmt->execute()) {
    echo "Foglalás sikeresen mentve!";
    header("Location: koszonjuk.php");
    exit;
} else {
    echo "Hiba történt: " . $stmt->error;
}

$conn->close();
?>
