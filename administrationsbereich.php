<?php
session_start();
// Überprüfung, ob eine Session gestartet wurde und ob der Benutzer angemeldet ist.
// Wenn nicht, wird der Benutzer zur Anmeldesseite weitergeleitet.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: anmeldung.php');
  exit;
}
?>

<?php
$id = '';
$name = '';
$kategorieid = '';
$kategorie = '';
$bildbeschreibung = '';
$bild = '';
$autorid = '';

// Überprüfung der Länge der Eingabefelder.
// Wenn die maximale Länge überschritten wird, wird eine Fehlermeldung ausgegeben und das Skript beendet.
if (strlen($id) > 11) {
  echo 'Die ID darf maximal 11 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

if (strlen($name) > 255) {
  echo 'Der Name darf maximal 255 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

if (strlen($kategorieid) > 10) {
  echo 'Die Kategorie ID darf maximal 10 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

if (strlen($kategorie) > 20) {
  echo 'Die Kategorie darf maximal 20 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

if (strlen($bildbeschreibung) > 50) {
  echo 'Die Bildbeschreibung darf maximal 50 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

if (strlen($bild) > 255) {
  echo 'Das Bild darf maximal 255 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

if (strlen($autorid) > 11) {
  echo 'Das Autor ID darf maximal 11 Zeichen lang sein.';
  echo "<br><br>";
  echo "<a href='administrationsbereich.php'>Zurück zum Administrationsbereich</a>";
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrationsbereich</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#administrationsbereich">Administrationsbereich</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/home_admin.php">News</a></li>
</ul>

<!-- Überschrift -->
<h1>Administrationsbereich</h1><br><br>


<!-- Formular für die Eingabe der AutorenID -->
<form action="administrationsbereich.php" method="POST">
<label for="Benutzername">Bitte geben Sie Ihren Benutzernamen für Ihre AutorenID ein:</label>
<input type="text" id="Benutzername" name="Benutzername"><br><br>

<input type="submit" name="submit" value="Abschicken"><br><br>

</form>
<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn ->connect_error);
}

if (isset($_POST['submit'])){
$benutzername = $_POST['Benutzername'];
}

// Vorbereiten und Ausführen einer SELECT-Abfrage, um die AutorID basierend auf dem eingegebenen Benutzernamen zu erhalten.
$stmt = $conn->prepare("SELECT uid FROM users WHERE Benutzername = ?");
$stmt->bind_param("s", $benutzername);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Überprüfen, ob ein Ergebnis gefunden wurde.
// Wenn ja, wird die AutorID angezeigt.
// Andernfalls wird eine Fehlermeldung ausgegeben.
if ($row) {
    $uid = $row['uid'];
    echo "Ihre AutorenID lautet: " . $uid . "<br><br>";
}else{
    echo "Der Benutzername ist falsch.<br><br>";
}
$stmt->close();
?>
<br><br>

<!-- Formular für die Eingabe der News Daten -->
<form action="administrationsbereich.php" method="POST">
<label for="ID">ID:</label>
<input type="text" id="ID" name="ID" required maxlength="11"><br><br><br><br>

<label for="Name">Name:</label>
<input type="text" id="Name" name="Name" required maxlength="255"><br><br><br><br>

Beschreibung: <br><br>
<textarea name="message" rows="10" cols="30">
</textarea><br><br><br><br>

<label for="gueltigVon">Gültig von:</label>
<input type="date" id="gueltigVon" name="gueltigVon"><br><br>

<label for="gueltigBis">Gültig bis:</label>
<input type="date" id="gueltigBis" name="gueltigBis"><br><br><br><br>

<label for="erstelltam">Erstellungsdatum:</label>
<input type="date" id="erstelltam" name="erstelltam"><br><br><br><br>

<label for="Kategorie">Kategorie:</label>
<select id="Kategorie" name="Kategorie" required>

  <?php
// Abfrage aller Kategorien aus der Datenbank.
 $query = "SELECT kid, kategorie FROM kategories";
 $result = $conn->query($query);
// Ausgabe der Kategorien in einer Dropdown-Liste. 
 while ($row = $result->fetch_assoc()) {
   echo "<option value='" . $row['kid'] . "'>" . $row['kategorie'] . "</option>";
 }
 ?>
</select><br><br><br><br>
  


<label for="Bildbeschreibung">Bildbeschreibung:</label>
<input type="text" id="Bildbeschreibung" name="Bildbeschreibung" maxlength="50"><br><br><br><br>

<label for="Bild">Bild:</label>
<input type="text" id="Bild" name="Bild" maxlength="255"><br><br><br><br>

<label for="AutorID">AutorID:</label>
<input type="text" id="AutorID" name="AutorID" required maxlength="11"><br><br><br><br>

<input type="submit" value="Daten speichern">
<input type="reset">
</form>


<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

// Verbindung zur Datenbank herstellen.
$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüfen, ob die Verbindung erfolgreich hergestellt wurde.
// Wenn nicht, wird eine Fehlermeldung ausgegeben und das Skript beendet.
if ($conn->connect_error) {
    die("Connection failed: " . $conn ->connect_error);
}

if (isset($_POST['ID']) && isset($_POST['Name']) && isset($_POST['message']) && isset($_POST['gueltigVon']) && isset($_POST['gueltigBis']) && isset($_POST['erstelltam']) && isset($_POST['Kategorie']) && isset($_POST['Bildbeschreibung']) && isset($_POST['Bild']) && isset($_POST['AutorID'])){
$id = $_POST['ID'];
$name = $_POST['Name'];
$beschreibung = $_POST['message'];
$gültigvon = $_POST['gueltigVon'];
$gültigbis = $_POST['gueltigBis'];
$erstellungsdatum = $_POST['erstelltam'];
$kategorieid = $_POST['Kategorie'];
$bildbeschreibung = $_POST['Bildbeschreibung'];
$bild = $_POST['Bild'];
$autorid = $_POST['AutorID'];
}


if (!empty($id) && !empty($name) && !empty($beschreibung) && !empty($gültigvon) && !empty($gültigbis) && !empty($erstellungsdatum) && !empty($kategorieid) && !empty($bildbeschreibung) && !empty($bild) && !empty($autorid)) {
  // Vorbereiten und Ausführen eines INSERT-Statements, um die eingegebenen Daten in die Tabelle 'news' einzufügen.  
  $stmt = $conn->prepare ('Insert INTO news (newsID, titel, inhalt, gueltigVon, gueltigBis, erstelltam, kid, link, bild, autor)
  Values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->bind_param('ssssssssss', $id, $name, $beschreibung, $gültigvon, $gültigbis, $erstellungsdatum, $kategorieid, $bildbeschreibung, $bild, $autorid);

// Überprüfen, ob das Statement erfolgreich ausgeführt wurde.
// Wenn ja, wird eine Erfolgsmeldung angezeigt.
// Andernfalls wird eine Fehlermeldung ausgegeben.
if ($stmt->execute() === TRUE) {
    echo "New record created successfully";
    echo "<br><br>"
    ;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
$stmt->close();
}
$conn->close();
?>


</body>
</html>

