<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Szobafoglalás</title>
  <link rel="stylesheet" href="./assets/css/foglalas.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="navdiv">
        <div class="logo"><a href="index.php">Hotel Anna</a></div>
        <ul>
          <li><a href="foglalas.php">Foglalás</a></li>
          <li><a href="szobak.php">Szobák</a></li>
          <li><a href="szolgaltatasok.php">Szolgáltatások</a></li>
          <li><a href="kapcsolat.php">Kapcsolat</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <?php
    if (isset($_GET['error'])) {
      echo '<div class="alert error">Hiba történt a foglalás során: ' . htmlspecialchars($_GET['error']) . '</div>';
    }
    if (isset($_GET['success'])) {
      echo '<div class="alert success">' . htmlspecialchars($_GET['success']) . '</div>';
    }
    ?>

    <form id="foglalasiUrlap" action="foglalas_mentes.php" method="post" onsubmit="return ellenorizUrlap()">
      <label for="nev">Név:</label>
      <input type="text" name="nev" required><br>

      <label for="email">Email:</label>
      <input type="email" name="email" required><br>

      <label for="szobatipus">Szobatípus:</label>
      <select name="szobatipus" id="szobatipus" required>
        <option value="">-- Válasszon szobatípust --</option>
        <option value="classic">Classic szoba (max 2 fő)</option>
        <option value="terasz">Szoba terasszal (max 2 fő)</option>
        <option value="csaladi">Családi szoba (max 4 fő)</option>
        <option value="lakosztaly">Lakosztály (max 6 fő)</option>
      </select><br>

      <label for="vendegszam">Vendégek száma:</label>
      <input type="number" name="vendegszam" id="vendegszam" min="1" max="6" required>
      <div id="kapacitasUzenet" class="error-message"></div><br>

      <label for="erkezes">Érkezés dátuma:</label>
      <input type="date" name="erkezes" id="erkezes" required min="<?php echo date('Y-m-d'); ?>">
      <div id="datumUzenet" class="error-message"></div><br>

      <label for="tavozas">Távozás dátuma:</label>
      <input type="date" name="tavozas" id="tavozas" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"><br>

      <button type="submit">Foglalás</button>
    </form>
  </main>

<script>
  const maxKapacitas = {
    "classic": 2,
    "terasz": 2,
    "csaladi": 4,
    "lakosztaly": 6};

  document.addEventListener("DOMContentLoaded", function () {
    const szobatipusSelect = document.getElementById("szobatipus");
    const vendegszamInput = document.getElementById("vendegszam");
    const kapacitasUzenet = document.getElementById("kapacitasUzenet");
    const erkezesInput = document.getElementById("erkezes");
    const tavozasInput = document.getElementById("tavozas");
    const datumUzenet = document.getElementById("datumUzenet");

    szobatipusSelect.addEventListener("change", function () {
      if (!this.value) {
        vendegszamInput.max = 6;
        vendegszamInput.value = 1;
        kapacitasUzenet.textContent = "";
        return;}
      
      const max = maxKapacitas[this.value];
      vendegszamInput.max = max;
      
      
      if (parseInt(vendegszamInput.value) > max) {
        vendegszamInput.value = max;}
      kapacitasUzenet.textContent = `Maximum ${max} vendég`;});

    vendegszamInput.addEventListener("change", function () {
      const szobatipus = szobatipusSelect.value;
      if (!szobatipus) {
        kapacitasUzenet.textContent = "Előbb válasszon szobatípust!";
        return;}
      
      const vendegszam = parseInt(this.value);
      const max = maxKapacitas[szobatipus];
      
      if (vendegszam > max) {
        this.value = max;
        kapacitasUzenet.textContent = `A kiválasztott szoba maximum ${max} főt tud befogadni!`;
      } else {
        kapacitasUzenet.textContent = `Maximum ${max} vendég`;}});

    erkezesInput.addEventListener("change", function () {
      if (!this.value) {
        return;}
      
      const erkezesDatum = new Date(this.value);
      const holnapiDatum = new Date(erkezesDatum);
      holnapiDatum.setDate(erkezesDatum.getDate() + 1);

      const minTavozas = holnapiDatum.toISOString().split('T')[0];
      tavozasInput.min = minTavozas;

      if (tavozasInput.value && tavozasInput.value < minTavozas) {
        tavozasInput.value = minTavozas;
      }
      
      if (tavozasInput.value) {
        const tavozasDatum = new Date(tavozasInput.value);
        const napok = Math.ceil((tavozasDatum - erkezesDatum) / (1000 * 60 * 60 * 24));
        if (napok < 1) {
          tavozasInput.value = minTavozas;
          datumUzenet.textContent = "Legalább 1 éjszakát kell foglalni!";
        } else {
          datumUzenet.textContent = "";}}});
    tavozasInput.addEventListener("change", function () {
      if (!erkezesInput.value || !this.value) {
        return;}
      
      const erkezesDatum = new Date(erkezesInput.value);
      const tavozasDatum = new Date(this.value);
      
      if (tavozasDatum <= erkezesDatum) {
        const holnapiDatum = new Date(erkezesDatum);
        holnapiDatum.setDate(erkezesDatum.getDate() + 1);
        this.value = holnapiDatum.toISOString().split('T')[0];
        datumUzenet.textContent = "Legalább 1 éjszakát kell foglalni!";
      } else {
        datumUzenet.textContent = "";
      }});});

  function ellenorizUrlap() {
    const szobatipus = document.getElementById("szobatipus").value;
    const vendegszam = parseInt(document.getElementById("vendegszam").value, 10);
    const erkezes = document.getElementById("erkezes").value;
    const tavozas = document.getElementById("tavozas").value;
    const kapacitasUzenet = document.getElementById("kapacitasUzenet");
    const datumUzenet = document.getElementById("datumUzenet");

    
    if (!szobatipus) {
      alert("Válasszon szobatípust!");
      return false;
    }

   
    const max = maxKapacitas[szobatipus];
    if (vendegszam > max) {
      kapacitasUzenet.textContent = `A kiválasztott szoba maximum ${max} főt tud befogadni!`;
      alert("A megadott vendégszám meghaladja a kiválasztott szobatípus kapacitását!");
      return false;
    }

    if (!erkezes || !tavozas) {
      alert("Töltse ki mindkét dátum mezőt!");
      return false;
    }

    const erkezesDatum = new Date(erkezes);
    const tavozasDatum = new Date(tavozas);
    
    if (tavozasDatum <= erkezesDatum) {
      datumUzenet.textContent = "A távozás dátuma későbbinek kell lennie az érkezésénél!";
      alert("A távozás dátuma későbbinek kell lennie az érkezésénél!");
      return false;}
      return true;}
</script>

</body>
</html>
