<?php
require 'db_connect.php'; // Include the database connection
session_start(); // Start the session

// Initialize variables for search query results
$users = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    
    // Search for users based on firstname and lastname
    $stmt = $pdo->prepare("SELECT id, firstname, lastname FROM users WHERE firstname LIKE :firstname AND lastname LIKE :lastname");
    $stmt->execute([
        'firstname' => "%" . $firstname . "%",
        'lastname' => "%" . $lastname . "%"
    ]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαγραφή Χρήστη</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="indexTutor.php">Αρχική σελίδα</a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container mt-5">
        <h1 class="text-center">Διαγραφή Χρήστη</h1>

        <!-- Display Error/Success Messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <form action="deleteUserForm.php" method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">Όνομα</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Όνομα" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Επίθετο</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Επίθετο" required>
            </div>
            <button type="submit" class="btn btn-primary" name="search">Αναζήτηση</button>
        </form>

        <!-- Display Search Results -->
        <?php if (count($users) > 0): ?>
            <form action="process.php" method="POST">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Επιλέξτε Χρήστη προς Διαγραφή</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>">
                                <?php echo htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger" name="action" value="delete">Διαγραφή Χρήστη</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">Δεν βρέθηκαν χρήστες για τα κριτήρια αναζήτησης.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
