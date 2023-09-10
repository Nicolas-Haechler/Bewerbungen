<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#home">Home</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/archiv.php">Archiv</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/registrierung.php">Registrierung</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/anmeldung.php">Login</a></li>
</ul>

<!-- Überschrift -->
<h1>News</h1>

<form action="home.php" method="POST"> <!-- Formular zum Filtern der News -->
    <label for="kategorie">Kategorie:</label> <!-- Beschriftung der Kategorie-Dropdownliste -->
    <select id="kategorie" name="kategorie"> <!-- Dropdownliste mit allen Kategorien -->
        <option value="">Alle Kategorien</option> <!-- Standardwert -->

        <?php
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "news";

        $conn = new mysqli($servername, $username, $password, $dbname); // Verbindung zur Datenbank herstellen

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM kategories"; // Abfrage, um alle Kategorien abzurufen
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()){
                $kategorieID = $row['kid'];
                $kategorieName = $row['kategorie'];
                echo "<option value='$kategorieID'>$kategorieName</option>"; // Optionen für die Kategorien generieren
            }
        }

        $conn->close();
        ?>

    </select>
    <input type="submit" name="filter" value="Filtern"> <!-- Filter-Button -->
</form>

<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

$conn = new mysqli($servername, $username, $password, $dbname); // Verbindung zur Datenbank herstellen

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM news ORDER BY gueltigVon DESC"; // Standard-Abfrage, um alle News nach dem Datum absteigend zu sortieren.
$kategorieFilter = isset($_POST['kategorie']) ? $_POST['kategorie'] : '';

if (!empty($kategorieFilter)) {
    $sql = "SELECT * FROM news WHERE kid = '$kategorieFilter' ORDER BY gueltigVon DESC"; // Wenn eine Kategorie ausgewählt wurde, die Abfrage entsprechend anpassen.
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class=\"news-container\">";
    while ($row = $result->fetch_assoc()) {
        $id = $row['newsID'];
        $titel = $row['titel'];
        $beschreibung = $row['inhalt'];
        $gueltigVon = $row['gueltigVon'];
        $bildbeschreibung = $row['link'];
        $bild = $row['bild'];
        $gueltigBis = $row['gueltigBis'];
        $kategorieID = $row['kid'];

        $currentDate = date("Y-m-d");
        if ($currentDate >= $gueltigVon && $currentDate <= $gueltigBis) {
            echo "<div class=\"news-item\">";
            echo "<h2>$titel</h2>";
            echo "<p>$beschreibung</p>";
            if (!empty($bild)) {
                echo "<a href=\"$bildbeschreibung\" target=\"_blank\">$bildbeschreibung</a>"; // Link zum Bild anzeigen, falls vorhanden
            }
            echo "<br>";
            echo "<br>";
            echo "<img src='" . $row['bild'] . "' alt='Bild' width='200'>";
            echo "<p>Kategorie: $kategorieID</p>";
            echo "<form action=\"news.php\" method=\"GET\">"; // Formular zur Anzeige der Details einer bestimmten News
            echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
            echo "<button type=\"submit\">Details anzeigen</button>";
            echo "</form>";
            echo "</div>";
        }
    }
    echo "</div>";
} else {
    echo "Keine News vorhanden";
}

$conn->close();
?>

</body>
</html>

