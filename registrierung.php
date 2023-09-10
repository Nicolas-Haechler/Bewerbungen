<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Überprüfen, ob die Seite über POST aufgerufen wurde
    if (isset($_POST['submit'])) { // Überprüfen, ob der Submit-Button gedrückt wurde
        $passwort = $_POST['Passwort']; // Passwort aus Formular auslesen

        if (strlen($passwort) < 6 || strlen($passwort) > 255) { // Überprüfen, ob das Passwort die richtige Länge hat
            echo 'Das Passwort muss mindestens 6 und maximal 255 Zeichen lang sein.'; // Fehlermeldung ausgeben
            echo "<br><br>"; // Zeilenumbruch
            echo "<a href='registrierung.php'>Zurück zur Registrierung</a>"; // Link zur Registrierung
            exit;
        }

        if (strlen($benutzername) > 20) { // Überprüfen, ob der Benutzername die richtige Länge hat
          echo 'Der Benutzername darf maximal 20 Zeichen lang sein.'; // Fehlermeldung ausgeben
          echo "<br><br>"; // Zeilenumbruch
          echo "<a href='registrierung.php'>Zurück zur Registrierung</a>"; // Link zur Registrierung
          exit;
        }

        if (strlen($vorname) > 50) {
         echo 'Der Vorname darf maximal 50 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        if (strlen($nachname) > 50) {
         echo 'Der Nachname darf maximal 50 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
        exit;
        }

        if (strlen($strasse) > 50) {
         echo 'Der Strassenname darf maximal 50 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        if (strlen($plz) > 15) {
         echo 'Die PLZ darf maximal 15 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        if (strlen($ort) > 50) {
         echo 'Der Ortsname darf maximal 50 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        if (strlen($land) > 50) {
         echo 'Das Land darf maximal 50 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        if (strlen($email) > 30) {
         echo 'Die E-Mail-Adresse darf maximal 30 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        if (strlen($telefon) > 11) {
         echo 'Die Telefonnummer darf maximal 11 Zeichen lang sein.';
         echo "<br><br>";
         echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
         exit;
        }

        header('Location: anmeldung.php'); // Weiterleitung zur Anmeldung
    }

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#registrierung">Home</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/home.php">News</a></li>
</ul>

<!-- Überschrift -->
<h1>Registrierung</h1>

<h2>Bitte geben Sie Ihren Usernamen und Ihr Passwort ein.</h2>

<form action="registrierung.php" method="POST"> <!-- Formular für die Registrierung -->
<label for="Benutzername">Benutzername:</label>
<input type="text" id="Benutzername" name="Benutzername" required maxlength="20"><br><br>

<label for="Passwort">Passwort:</label>
<input type="password" id="Passwort" name="Passwort" required minlength="6" maxlength="255"><br><br>

  <label for="Anrede">Wählen Sie Ihre Anrede:</label>
  <select name="Anrede" id="Anrede">
    <option value="Herr">Herr</option>
    <option value="Frau">Frau</option>
  </select>
  <br><br>

<label for="Vorname">Vorname:</label>
<input type="text" id="Vorname" name="Vorname" required maxlength="50"><br><br>

<label for="Nachname">Nachname:</label>
<input type="text" id="Nachname" name="Nachname" required maxlength="50"><br><br>

<label for="Strasse">Strasse:</label>
<input type="text" id="Strasse" name="Strasse" maxlength="50"><br><br>

<label for="PLZ">PLZ:</label>
<input type="text" id="PLZ" name="PLZ" maxlength="15"><br><br>

<label for="Ort">Ort:</label>
<input type="text" id="Ort" name="Ort" maxlength="50"><br><br>

<label for="Land">Land:</label>
<input type="text" id="Land" name="Land" maxlength="50"><br><br>

<label for="EMail_Adresse">EMail_Adresse:</label>
<input type="text" id="EMail_Adresse" name="EMail_Adresse" maxlength="30"><br><br>

<label for="Telefon">Telefon:</label>
<input type="text" id="Telefon" name="Telefon" maxlength="11"><br><br>


<input type="submit" name="submit" value="Daten speichern">

<input type="reset">


<?php 
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "news";

$conn = new mysqli($servername, $username, $password, $dbname); // Verbindung zur Datenbank herstellen

if ($conn->connect_error) {
    die("Connection failed: " . $conn ->connect_error); // Verbindung zur Datenbank fehlgeschlagen
}



if (isset($_POST['submit'])){ // Wenn der Button gedrückt wurde, dann...
$benutzername = $_POST['Benutzername']; // ... die Daten aus dem Formular in Variablen speichern
$passwort = $_POST['Passwort'];
$gehashtesPasswort = password_hash($passwort, PASSWORD_DEFAULT); // Passwort wird gehasht
$anrede = $_POST['Anrede'];
$vorname = $_POST['Vorname'];
$nachname = $_POST['Nachname'];
$strasse = $_POST['Strasse'];
$plz = $_POST['PLZ'];
$ort = $_POST['Ort'];
$land = $_POST['Land'];
$email = $_POST['EMail_Adresse'];
$telefon = $_POST['Telefon'];
}

// Überprüfung, ob alle Felder ausgefüllt wurden
if (!empty($benutzername) && !empty($passwort) && !empty($anrede) && !empty($vorname) && !empty($nachname) && !empty($strasse) && !empty($plz) && !empty($ort) && !empty($land) && !empty($email) && !empty($telefon)) {
  $stmt = $conn->prepare ('Insert INTO users (Benutzername, Passwort, Anrede, Vorname, Nachname, Strasse, PLZ, Ort, Land, EMail_Adresse, Telefon) 
Values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'); // SQL-Statement wird vorbereitet
$stmt->bind_param('sssssssssss', $benutzername, $gehashtesPasswort, $anrede, $vorname, $nachname, $strasse, $plz, $ort, $land, $email, $telefon); // Parameter werden gebunden

$sel = "SELECT Benutzername FROM users WHERE Benutzername = '$benutzername'"; // Überprüfung, ob der Benutzername bereits vergeben ist
$result = $conn->query($sel); // SQL-Statement wird ausgeführt

if ($result->num_rows > 0) { // Wenn der Benutzername bereits vergeben ist, dann...
  header('Location: neuerBenutzername.php'); // ... Weiterleitung zu neuerBenutzername.php
  exit; // Skript wird beendet
}


if ($stmt->execute() === TRUE) { // Wenn das SQL-Statement erfolgreich ausgeführt wurde, dann...
    echo "New record created successfully"; // ... wird eine Erfolgsmeldung ausgegeben
    ;
  } else { // Wenn das SQL-Statement nicht erfolgreich ausgeführt wurde, dann...
    echo "Error: " . $sql . "<br>" . $conn->error; // ... wird eine Fehlermeldung ausgegeben
  }
  $stmt->close(); // SQL-Statement wird geschlossen
}
  $conn->close(); // Verbindung zur Datenbank wird geschlossen

     
?>

</body>
</html>


