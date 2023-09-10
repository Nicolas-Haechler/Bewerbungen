<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Detailansicht</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#detailansicht">Detailansicht</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/home.php">News</a></li>
</ul>

<!-- Überschrift -->
<h1>News</h1>

<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

$conn = new mysqli($servername, $username, $password, $dbname); // Verbindung zur Datenbank herstellen

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Bei Verbindungsfehler abbrechen
}

$id = $_GET['id']; // ID aus der URL abrufen

$sql = "SELECT * FROM news WHERE newsID = '$id'"; // SQL-Abfrage, um die News mit der entsprechenden ID abzurufen.
$result = $conn->query($sql); // SQL-Abfrage ausführen

if ($result->num_rows > 0) { // Überprüfen, ob die Abfrage Ergebnisse zurückgeliefert hat.
    $row = $result->fetch_assoc(); // Ergebnis in ein Array speichern
    $NID = $row['newsID']; // Array auslesen
    $titel = $row['titel']; 
    $beschreibung = $row['inhalt'];
    $gueltigVon = $row['gueltigVon'];
    $erstelltAm = $row['erstelltam'];
    $bildbeschreibung = $row['link'];
    $bild = $row['bild'];
    $gueltigBis = $row['gueltigBis'];
    $kategorieID = $row['kid'];
    $AID = $row['autor'];

    $sql = "SELECT * FROM kategories WHERE kid = '$kategorieID'"; // SQL-Abfrage, um die Kategorie mit der entsprechenden ID abzurufen.
    $result = $conn->query($sql); // SQL-Abfrage ausführen

    if ($result->num_rows > 0) { // Überprüfen, ob die Abfrage Ergebnisse zurückgeliefert hat.
        $row = $result->fetch_assoc(); // Ergebnis in ein Array speichern
        $kategorie = $row['kategorie']; // Array auslesen
    }

    $sql = "SELECT * FROM users WHERE uid = '$AID'"; // SQL-Abfrage, um den Autor mit der entsprechenden ID abzurufen.
    $result = $conn->query($sql); // SQL-Abfrage ausführen
    $aktuelleNutzerID = $AID; // Aktuelle NutzerID speichern
    $erstellerID = $AID; // ErstellerID speichern
    $istErsteller = ($aktuelleNutzerID == $erstellerID); // Überprüfen, ob der aktuelle Nutzer der Ersteller ist

    echo "<div>"; // News ausgeben
    echo "<h2>$titel</h2>";
    echo "<p>NewsID: $NID</p>";
    echo "<p>$beschreibung</p>";
    echo "<p>Gültig Von: $gueltigVon</p>";
    echo "<p>Gültig Bis: $gueltigBis</p>";
    echo "<p>Erstellt am: $erstelltAm</p>";

    if (!empty($bild)) {
        echo "<a href=\"$bildbeschreibung\" target=\"_blank\">$bildbeschreibung</a>";
    }
    echo "<br>";
    echo "<br>";
    echo "<img src='$bild' alt='Bild' width='200'>";
    echo "<p>KategorieID: $kategorieID</p>";
    echo "<p>Kategorie: $kategorie</p>";
    echo "<p>AutorID: $AID</p>";

    if ($istErsteller) { // Überprüfen, ob der aktuelle Nutzer der Ersteller ist
        echo "<form action=\"update.php\" method=\"GET\">"; // Formular zum Aktualisieren der News
        echo "<input type=\"hidden\" name=\"id\" value=\"$id\">"; // ID versteckt übergeben
        echo "<button type=\"submit\">Aktualisieren</button>"; // Button zum Aktualisieren der News
        echo "</form>";

        echo "<form action=\"delete.php\" method=\"POST\">"; // Formular zum Löschen der News
        echo "<input type=\"hidden\" name=\"id\" value=\"$id\">"; // ID versteckt übergeben
        echo "<button type=\"submit\">Löschen</button>"; // Button zum Löschen der News
        echo "</form>";
    }

    echo "</div>";
} else {
    echo "News not found."; // Fehlermeldung, wenn die News nicht gefunden wurde
}

$conn->close(); // Verbindung zur Datenbank schließen
?>

</body>
</html>
