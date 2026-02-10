<?php
require 'db_connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve input values from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate the inputs
    if (empty($email) || empty($password)) {
        header("Location: identification.php?error=" . urlencode("Please fill in all fields."));
        exit();
    }

    try {
        // Query the database for the user by email
        $stmt = $pdo->prepare("SELECT email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if the entered password matches the stored password
            if ($password === $user['password']) {
                // Redirect based on role
                if ($user['role'] === 'Student') {
                    header("Location: studentPage.php");
                } elseif ($user['role'] === 'Tutor') {
                    header("Location: indexTutor.php");
                } else {
                    header("Location: identification.php?error=" . urlencode("Unknown user role."));
                }
                exit();
            } else {
                // Invalid password
                header("Location: identification.php?error=" . urlencode("Incorrect password."));
                exit();
            }
        } else {
            // No user found with the provided email
            header("Location: identification.php?error=" . urlencode("No user found with this email."));
            exit();
        }
    } catch (Exception $e) {
        // Log any errors and redirect with a generic error message
        error_log("Error in identification.php: " . $e->getMessage());
        header("Location: identification.php?error=" . urlencode("An unexpected error occurred."));
        exit();
    }
} else {
    // Display the form, including any error messages
    $error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : "";
}
?>
<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Πιστοποίηση</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        form {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <form action="identification.php" method="post">
        <h1>Πιστοποίηση</h1>

        <!-- Error message display -->
        <?php if (!empty($error)): ?>
        <div class="error">
            <?= $error ?>
        </div>
        <?php endif; ?>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        
        <button type="submit">Σύνδεση</button>
    </form>
</body>

</html>
