<?php
session_start(); // Session starten
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { // Überprüfen, ob der Nutzer eingeloggt ist
  header('Location: anmeldung.php'); // Wenn nicht, dann auf die Anmeldeseite weiterleiten
  exit; // Skript beenden
}
?>
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


    echo "<div>"; // HTML-Code zur Darstellung des Formulars
    echo "<h2>News aktualisieren</h2>";
    echo "<form action=\"update_durchführen.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
    echo "Titel: <input type=\"text\" name=\"titel\" value=\"$titel\"><br>";
    echo "Beschreibung: <textarea name=\"beschreibung\">$beschreibung</textarea><br>";
    echo "Gültig Von: <input type=\"text\" name=\"gueltigVon\" value=\"$gueltigVon\"><br>";
    echo "Gültig Bis: <input type=\"text\" name=\"gueltigBis\" value=\"$gueltigBis\"><br>";
    echo "Erstellt am: <input type=\"text\" name=\"erstelltAm\" value=\"$erstelltAm\"><br>";
    echo "Bildbeschreibung: <input type=\"text\" name=\"bildbeschreibung\" value=\"$bildbeschreibung\"><br>";
    echo "Bild: <input type=\"text\" name=\"bild\" value=\"$bild\"><br>";
    echo "<input type=\"submit\" value=\"Aktualisieren\">";
    echo "</form>";
    echo "</div>";
} else {
    echo "News not found.";
}

$conn->close();

?>
<br>
<br>
<a href="home.php">Zurück zur Startseite</a> <!-- Link zur Startseite -->