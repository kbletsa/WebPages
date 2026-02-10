<?php
$servername = "webpagesdb.it.auth.gr";
$username = "Maritina";
$password = "Mar12345";
$dbname = "student4239";
$charset = "utf8mb4";

try {
    $dsn = "mysql:host=$servername;port=3306;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Ενεργοποίηση exceptions σε περίπτωση σφάλματος
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Ορισμός προεπιλεγμένης λειτουργίας fetch
        PDO::ATTR_EMULATE_PREPARES => false, // Απενεργοποίηση εξομοίωσης prepared statements για μεγαλύτερη ασφάλεια
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
