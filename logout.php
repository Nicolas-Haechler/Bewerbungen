<?php
session_start(); // Session starten
session_destroy(); // Session zerstören
header('Location: anmeldung.php'); // Zurück zur Anmeldung
exit; // Skript beenden
?>