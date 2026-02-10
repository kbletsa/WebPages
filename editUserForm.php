<?php
require 'db_connect.php'; // Include the database connection
session_start(); // Start the session

// Initialize variables for search query results
$users = [];
$user = null;

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

if (isset($_GET['id'])) {
    // Fetch the user details from the database based on the ID
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        // If user not found, redirect with error
        header("Location: indexTutor.php?error=User%20not%20found");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Χρήστη</title>
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
        <h1 class="text-center">Επεξεργασία Χρήστη</h1>

        <!-- Display Error/Success Messages -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <!-- Search Form -->
        <form action="editUserForm.php" method="POST">
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
            <form action="editUserForm.php" method="GET">
                <div class="mb-3">
                    <label for="user_id" class="form-label">Επιλέξτε Χρήστη προς Επεξεργασία</label>
                    <select class="form-select" id="user_id" name="id" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>">
                                <?php echo htmlspecialchars($user['firstname']) . " " . htmlspecialchars($user['lastname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">Επεξεργασία Χρήστη</button>
            </form>
        <?php elseif ($user): ?>
            <!-- Display User Data for Editing -->
            <form action="process.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Όνομα</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Επίθετο</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Ρόλος</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="Tutor" <?php if ($user['role'] === 'Tutor') echo 'selected'; ?>>Tutor</option>
                        <option value="Student" <?php if ($user['role'] === 'Student') echo 'selected'; ?>>Student</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning" name="edit">Επεξεργασία Χρήστη</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">Δεν βρέθηκαν χρήστες για τα κριτήρια αναζήτησης.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
