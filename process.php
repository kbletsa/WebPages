<?php
require 'db_connect.php'; // Include the database connection

// Function to redirect with an error message
function redirectWithError($message) {
    header("Location: indexTutor.php?error=" . urlencode($message));
    exit();
}

// Function to redirect with a success message
function redirectWithSuccess($message) {
    header("Location: indexTutor.php?success=" . urlencode($message));
    exit();
}

// Initialize variables for user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'create':
                    createUser($pdo, $_POST); // Handle user creation
                    break;
                case 'edit':
                    editUser($pdo, $_POST); // Handle user editing
                    break;
                case 'delete':
                    deleteUser($pdo, $_POST); // Handle user deletion
                    break;
                case 'login':
                    loginUser($pdo, $_POST); // Handle user login
                    break;
                default:
                    redirectWithError("Invalid action");
            }
        } else {
            redirectWithError("No action specified");
        }
    } catch (Exception $e) {
        // Log errors and redirect with a generic error
        error_log("Error in process.php: " . $e->getMessage());
        header("Location: indexTutor.php?error=An%20unexpected%20error%20occurred");
        exit();
    }
} else {
    // Reject invalid request methods
    header("Location: indexTutor.php?error=Invalid%20request%20method");
    exit();
}

// Function to create a users   
function createUser($pdo, $data) {
    $firstname = trim($data['firstname']);
    $lastname = trim($data['lastname']);
    $email = trim($data['email']);
    $password = trim($data['password']);
    $role = trim($data['role']); // Capture the role
    
    // Check if all fields are filled
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($role)) {
        redirectWithError("All fields are required");
    }

    // Store password as plain text (NOT RECOMMENDED)
    // Prepare insert query
    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$firstname, $lastname, $email, $password, $role]);

    // Redirect with success message
    redirectWithSuccess("User created successfully");
}


// Function to delete a user
function deleteUser($pdo, $data) {
    $user_id = (int) $data['user_id'];

    // Check if user_id is valid
    if ($user_id <= 0) {
        redirectWithError("Invalid user ID");
    }

    // Prepare delete query
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    // Redirect with success message
    redirectWithSuccess("User deleted successfully");
}

// Function to edit user details
function editUser($pdo, $data) {
    $user_id = (int) $data['user_id'];
    $firstname = trim($data['firstname']);
    $lastname = trim($data['lastname']);
    $email = trim($data['email']);
    $role = trim($data['role']); // Capture the role

    // Check if user_id and all fields are filled
    if ($user_id <= 0 || empty($firstname) || empty($lastname) || empty($email) || empty($role)) {
        redirectWithError("All fields are required");
    }

    // Prepare update query
    $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, role = ? WHERE id = ?");
    $stmt->execute([$firstname, $lastname, $email, $role, $user_id]);

    // Redirect with success message
    redirectWithSuccess("User details updated successfully");
}

// Function to authenticate and login user (without password hashing)
function loginUser($pdo, $data) {
    $email = trim($data['email']);
    $password = trim($data['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        redirectWithError("Please enter both email and password.");
    }

    try {
        // Prepare query to fetch user based on email
        $stmt = $pdo->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and compare plain text password
        if ($user && $password === $user['password']) {
            // Start session and set user details
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'Tutor') {
                header("Location: dashboardTutor.php");
            } elseif ($user['role'] === 'Student') {
                header("Location: dashboardStudent.php");
            } else {
                header("Location: dashboardAdmin.php");
            }
            exit();
        } else {
            redirectWithError("Invalid email or password.");
        }
    } catch (Exception $e) {
        error_log("Error during login: " . $e->getMessage());
        redirectWithError("An unexpected error occurred.");
    }
}
?>
