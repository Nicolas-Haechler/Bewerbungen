<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archiv</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#archiv">Archiv</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/home.php">News</a></li>
</ul>

<!-- Überschrift -->
<h1>Archiv</h1>

<form action="archiv.php" method="POST"> <!-- Formular zum Filtern der News -->
    <label for="kategorie">Kategorie:</label> <!-- Beschriftung der Kategorie-Dropdownliste -->
    <select id="kategorie" name="kategorie"> <!-- Dropdownliste mit allen Kategorien -->
        <option value="">Alle Kategorien</option> <!-- Standardwert -->

        <?php
        // Verbindung zur Datenbank herstellen und Kategorien abrufen.
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "news";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM kategories";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()){
                $kategorieID = $row['kid'];
                $kategorieName = $row['kategorie'];
                echo "<option value='$kategorieID'>$kategorieName</option>"; // Optionen für Dropdownliste
            }
        }

        $conn->close();
        ?>

    </select>
    <input type="submit" name="filter" value="Filtern"> <!-- Filter-Button -->
</form>


<?php
// Verbindung zur Datenbank herstellen und News abrufen.
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variablen für die Paginierung
$seite = isset($_GET['seite']) ? $_GET['seite'] : 1;
$einträge_pro_seite = 6;
$offset = ($seite - 1) * $einträge_pro_seite;

// Abgelaufene News abrufen und anzeigen
$currentDate = date("Y-m-d");
$sql = "SELECT * FROM news WHERE '$currentDate' > gueltigBis ORDER BY gueltigVon DESC LIMIT $offset, $einträge_pro_seite";
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

        echo "<div class=\"news-item\">";
        echo "<h2>$titel</h2>"; // Titel
        echo "<p>$beschreibung</p>"; // Beschreibung
        if (!empty($bild)) {
            echo "<a href=\"$bildbeschreibung\" target=\"_blank\">$bildbeschreibung</a>"; // Bildbeschreibung
        }
        echo "<br>";
        echo "<br>";
        echo "<img src='" . $row['bild'] . "' alt='Bild' width='200'>"; // Bild
        echo "<p>Kategorie: $kategorieID</p>"; // Kategorie
        echo "<form action=\"news.php\" method=\"GET\">"; // Formular zum Anzeigen der Details
        echo "<input type=\"hidden\" name=\"id\" value=\"$id\">"; // Verstecktes Feld mit der ID der News
        echo "<button type=\"submit\">Details anzeigen</button>"; // Button zum Anzeigen der Details
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
    // Links zur Paginierung
    $total_pages_sql = "SELECT COUNT(*) AS total FROM news WHERE '$currentDate' > gueltigBis";
    $result = $conn->query($total_pages_sql);
    $total_rows = $result->fetch_assoc()['total'];
    $total_pages = ceil($total_rows / $einträge_pro_seite);

    echo "<br><br>";
    echo "Seiten: ";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='archiv.php?seite=$i'>$i</a> "; // Link zur jeweiligen Seite
    }
} else {
    echo "Keine abgelaufenen News vorhanden.";
}

$conn->close();
?>

</body>
</html>
