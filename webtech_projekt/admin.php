<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Hozzáférés megtagadva.");
}

$conn = new mysqli("localhost", "root", "", "hotel_anna");
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$sql = "SELECT id, nev, email, szobatipus, vendegszam, erkezes_datum, tavozas_datum 
        FROM foglalasok ORDER BY erkezes_datum ASC";
$result = $conn->query($sql);
if (!$result) {
    die("Lekérdezés hiba: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Admin felület - Foglalások</title>
    <link rel="stylesheet" href="./assets/css/admin.css">
</head>
<body>
    <h2 style="text-align:center;">Foglalások listája</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Név</th>
            <th>Email</th>
            <th>Szoba típus</th>
            <th>Vendégszám</th>
            <th>Érkezés</th>
            <th>Távozás</th>
            <th>Művelet</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nev']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['szobatipus']) ?></td>
                    <td><?= htmlspecialchars($row['vendegszam']) ?></td>
                    <td><?= htmlspecialchars($row['erkezes_datum']) ?></td>
                    <td><?= htmlspecialchars($row['tavozas_datum']) ?></td>
                    <td>
                        <a class="torles" 
                           href="torles.php?id=<?= htmlspecialchars($row['id']) ?>" 
                           onclick="return confirm('Biztosan törölni szeretnéd ezt a foglalást?');">
                           Törlés
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">Nincs foglalás.</td></tr>
        <?php endif; ?>
    </table>

    <p style="text-align:center;">
        <a href="logout.php">Kijelentkezés</a>
    </p>
</body>
</html>

<?php
$conn->close();
?>
