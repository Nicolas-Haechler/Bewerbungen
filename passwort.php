<?php
session_start(); // Session starten

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Überprüfen, ob die Seite über POST aufgerufen wurde
    if (isset($_POST['submit'])) { // Überprüfen, ob der Button "submit" gedrückt wurde
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "news";

        $conn = new mysqli($servername, $username, $password, $dbname); // Verbindung zur Datenbank herstellen

        if ($conn->connect_error) {
            die("Connection failed: " . $conn ->connect_error); // Bei Verbindungsfehler abbrechen
        }
        $benutzername = $_SESSION['Benutzername']; // Benutzername aus der Session auslesen
        $altesPasswort = $_POST['altesPasswort']; // Altes Passwort aus dem Formular auslesen
        $neuesPasswort = $_POST['neuesPasswort']; // Neues Passwort aus dem Formular auslesen

        $stmt = $conn->prepare("SELECT Passwort FROM users WHERE Benutzername = ?"); // SQL-Abfrage, um das Passwort des Benutzers abzurufen
        $stmt->bind_param("s", $benutzername); // Parameter an die SQL-Abfrage binden
        $stmt->execute(); // SQL-Abfrage ausführen
        $result = $stmt->get_result(); // Ergebnis der SQL-Abfrage abrufen
        $row = $result->fetch_assoc(); // Ergebnis in ein Array speichern

        if ($row) { // Überprüfen, ob ein Datensatz gefunden wurde
            $gespeichertesPasswort = $row['Passwort']; // Gespeichertes Passwort aus dem Array auslesen

            if (password_verify($altesPasswort, $gespeichertesPasswort)) { // Überprüfen, ob das eingegebene Passwort mit dem gespeicherten Passwort übereinstimmt
                if (strlen($neuesPasswort) < 6) { // Überprüfen, ob das neue Passwort mindestens 6 Zeichen lang ist
                    echo 'Das Passwort muss mindestens 6 Zeichen lang sein.'; // Fehlermeldung ausgeben
                    echo "<a href='passwort.php'>Zurück</a>"; // Link zur Passwort-Seite ausgeben
                    exit;
                }

                $neuesGehashtesPasswort = password_hash($neuesPasswort, PASSWORD_DEFAULT); // Neues Passwort hashen

                $updateStmt = $conn->prepare("UPDATE users SET Passwort = ? WHERE Benutzername = ?"); // SQL-Abfrage, um das Passwort des Benutzers zu aktualisieren
                $updateStmt->bind_param("ss", $neuesGehashtesPasswort, $benutzername); // Parameter an die SQL-Abfrage binden
                $updateStmt->execute(); // SQL-Abfrage ausführen

                echo "Das Passwort wurde erfolgreich geändert."; // Erfolgsmeldung ausgeben
                echo "<a href='anmeldung.php'>Zur Anmeldung</a>"; // Link zur Anmeldung-Seite ausgeben

                $updateStmt->close(); // SQL-Abfrage schließen
                $stmt->close(); // SQL-Abfrage schließen
                $conn->close(); // Verbindung zur Datenbank schließen
                exit; // Skript beenden
            } else { // Wenn das eingegebene Passwort nicht mit dem gespeicherten Passwort übereinstimmt
                echo "Das eingegebene alte Passwort ist falsch."; // Fehlermeldung ausgeben
                $stmt->close(); // SQL-Abfrage schließen
                $conn->close(); // Verbindung zur Datenbank schließen
            }
        } else { // Wenn kein Datensatz gefunden wurde
            echo "Benutzer nicht gefunden."; // Fehlermeldung ausgeben
            $stmt->close(); // SQL-Abfrage schließen
            $conn->close(); // Verbindung zur Datenbank schließen
        }
    }
}
?>
<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: anmeldung.php');
  exit;
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
if (strlen($neuesPasswort) < 6 || strlen($neuesPasswort) > 255) {
    echo 'Das Passwort muss mindestens 6 und maximal 255 Zeichen lang sein.';
    echo "<br><br>";
    echo "<a href='registrierung.php'>Zurück zur Registrierung</a>";
    exit;
}
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passwort ändern</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#passwort">Passwort ändern</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/home_admin.php">News</a></li>
</ul>

<!-- Überschrift -->
<h1>Passwort ändern</h1>

<form action="passwort.php" method="POST">
    <label for="altesPasswort">altes Passwort:</label>
    <input type="password" id="altesPasswort" name="altesPasswort" required minlength="6" maxlength="255"><br><br>

    <label for="neuesPasswort">neues Passwort:</label>
    <input type="password" id="neuesPasswort" name="neuesPasswort" required minlength="6" maxlength="255"><br><br>

    <input type="submit" name="submit" value="Passwort ändern">
    <input type="reset">
</form>

</body>
</html>
