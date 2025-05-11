<?php session_start(); ?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Admin bejelentkezés</title>
</head>
<body>
  <h2>Admin bejelentkezés</h2>
  <form action="login_check.php" method="post">
    <label for="username">Felhasználónév:</label>
    <input type="text" name="username" required><br>

    <label for="password">Jelszó:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Bejelentkezés</button>
  </form>
</body>
</html>
