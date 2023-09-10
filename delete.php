<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: anmeldung.php'); // Weiterleitung zur Anmeldungsseite, wenn der Benutzer nicht angemeldet ist
  exit;
}
?>
<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

$conn = new mysqli($servername, $username, $password, $dbname); // Verbindung zur Datenbank herstellen

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id']; // ID der zu löschenden News aus dem Formular erhalten

$sql = "SELECT * FROM news WHERE newsID = '$id'"; // Abfrage, um die News mit der gegebenen ID abzurufen
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $NID = $row['newsID'];
    $titel = $row['titel'];
    $beschreibung = $row['inhalt'];
    $gueltigVon = $row['gueltigVon'];
    $erstelltAm = $row['erstelltam'];
    $bildbeschreibung = $row['link'];
    $bild = $row['bild'];
    $gueltigBis = $row['gueltigBis'];
    $kategorieID = $row['kid'];
    $AID = $row['autor'];

    $sql = "SELECT * FROM kategories WHERE kid = '$kategorieID'"; // Abfrage, um die Kategorie der News abzurufen
    $result = $conn->query($sql);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $kategorieID = $row['kid'];
        $kategorie = $row['kategorie'];
    }

    $sql = "DELETE FROM news WHERE newsID = '$id'"; // Löschen der News mit der gegebenen ID
    $result = $conn->query($sql);
}

$conn->close();
?>
<br>
<br>
<a href="home.php">Zurück zur Startseite</a>