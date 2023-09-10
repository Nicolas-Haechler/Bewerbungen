<?php
session_start(); // Session starten
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { // Überprüfen, ob der Nutzer eingeloggt ist
  header('Location: anmeldung.php'); // Wenn nicht, dann zur Anmeldeseite weiterleiten
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

$id = $_POST['id']; // ID aus der URL abrufen
$titel = $_POST['titel']; // Titel aus dem Formular abrufen
$beschreibung = $_POST['beschreibung'];
$gueltigVon = $_POST['gueltigVon'];
$gueltigBis = $_POST['gueltigBis'];
$erstelltAm = $_POST['erstelltAm'];
$bildbeschreibung = $_POST['bildbeschreibung'];
$bild = $_POST['bild'];

// SQL-Abfrage, um die News mit der entsprechenden ID abzurufen.
$sql = "UPDATE news SET titel = '$titel', inhalt = '$beschreibung', gueltigVon = '$gueltigVon', gueltigBis = '$gueltigBis', erstelltam = '$erstelltAm', link = '$bildbeschreibung', bild = '$bild' WHERE newsID = '$id'";
$result = $conn->query($sql);
// SQL-Abfrage ausführen

if ($result === TRUE) { // Überprüfen, ob die Abfrage Ergebnisse zurückgeliefert hat.
    echo "News erfolgreich aktualisiert."; // Erfolgsmeldung ausgeben
} else { // Wenn nicht, dann Fehlermeldung ausgeben
    echo "Fehler beim Aktualisieren der News: " . $conn->error; // Fehlermeldung ausgeben
}

$conn->close(); // Verbindung zur Datenbank schließen


?>
<br>
<br>
<a href="home.php">Zurück zur Startseite</a> <!-- Link zur Startseite -->