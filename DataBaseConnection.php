<?php

$servername = "webpagesdb.it.auth.gr";
$username = "Maritina";
$password = "Mar12345";
$dbname = "student4239";
$port = 3306; // Αν το MySQL τρέχει σε διαφορετική πόρτα, εδώ αλλάζει

// Start session
session_start();

try {
    // Δημιουργία σύνδεσης με MySQL μέσω PDO
    $pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage()); // Χρησιμοποιούμε die για να σταματήσει η εκτέλεση σε περίπτωση αποτυχίας
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Login action
    if ($action === 'login' && !empty($email) && !empty($password)) {
        try {
            // Αναζήτηση χρήστη με το email
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Φέρνουμε τα στοιχεία του χρήστη
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Επιτυχής σύνδεση
                $_SESSION['username'] = $user['email'];  // Αποθήκευση email στη συνεδρία
                $_SESSION['role'] = $user['role'];       // Αποθήκευση ρόλου

                // Ανακατεύθυνση ανάλογα με τον ρόλο
                header("Location: " . ($user['role'] === 'Tutor' ? "indexTutor.html" : "indexStudent.html"));
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
