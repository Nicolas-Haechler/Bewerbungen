<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung</title>
    <link rel="stylesheet" href="news.css">
</head>
<body>

<!-- Navigation -->
<ul>
  <li><a class="active" href="#anmeldung">Anmeldung</a></li>
  <li><a href="http://localhost/IMS/UK295/Projekt/home.php">News</a></li>
</ul>

<!-- Überschrift -->
<h1>Anmeldung</h1>

<!-- Formular für die Nutzereingabe des Benutzernamen und des Passworts.-->
<form action="anmeldung.php" method="POST">
<label for="Benutzername">Benutzername:</label>
<input type="text" id="Benutzername" name="Benutzername"><br><br>

<label for="Passwort">Passwort:</label>
<input type="password" id="Passwort" name="Passwort"><br><br>

<input type="submit" name="submit" value="Daten speichern">

<input type="reset">

<?php 
// PHP-Code zur Überprüfung der Anmeldeinformationen.
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {

        // Verbindung zur Datenbank herstellen.
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "news";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Überprüfen, ob die Verbindung erfolgreich hergestellt wurde.
        if ($conn->connect_error) {
            die("Connection failed: " . $conn ->connect_error);
        }

        // Benutzername und Passwort aus dem Formular erhalten.
        $benutzername = $_POST['Benutzername'];
        $passwort = $_POST['Passwort'];

        // Vorbereiten und Ausführen einer SELECT-Abfrage, um das gespeicherte Passwort abzurufen.
        $stmt = $conn->prepare("SELECT Passwort FROM users WHERE Benutzername = ?");
        $stmt->bind_param("s", $benutzername);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Überprüfen, ob ein Datensatz gefunden wurde.
        if ($row) {
            $gespeichertesPasswort = $row['Passwort'];

            // Das eingegebene Passwort mit dem gespeicherten Passwort vergleichen.
            if (password_verify($passwort, $gespeichertesPasswort)) {
                // Anmeldung erfolgreich
                $_SESSION['loggedin'] = true;
                $_SESSION['Benutzername'] = $benutzername;
                header('Location: administrationsbereich.php');
                exit;
            }else{
                echo "Das Passwortund/oder der Benutzername ist falsch.";
        $stmt->close();
        $conn->close();
    }
    }
}
}
?>

</body>
</html>