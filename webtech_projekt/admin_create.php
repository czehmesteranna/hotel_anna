<?php
// Egyszeri admin létrehozása
$hash = password_hash("adminjelszo", PASSWORD_DEFAULT);

// Csatlakozás és mentés (ezt elég egyszer lefuttatni)
$conn = new mysqli("localhost", "root", "", "hotel_anna");
$conn->query("INSERT INTO adminok (felhasznalonev, jelszo_hash) VALUES ('admin', '$hash')");
echo "Admin hozzáadva!";
?>
