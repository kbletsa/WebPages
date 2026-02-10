<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $assignment_id = $_GET['id'];

    // Fetch the assignment from the database
    $stmt = $pdo->prepare("SELECT * FROM assignments WHERE id = :id");
    $stmt->bindParam(':id', $assignment_id, PDO::PARAM_INT);
    $stmt->execute();
    $assignment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$assignment) {
        echo "<p>Δεν βρέθηκε αυτή η εργασία.</p>";
        exit;
    }
}

// Start the session and generate CSRF token for security
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Εργασίας</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            max-width: 800px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        input[type="file"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #393fe1;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Επεξεργασία Εργασίας</h1>
        </div>
        <div class="main-content">
            <!-- Display error messages dynamically if needed -->
            <div class="error" id="error-message"></div>

            <form action="handling.php" method="POST" enctype="multipart/form-data">

                <!-- Hidden input to hold the assignment ID -->
                <input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>">

                <!-- Form Fields -->
                <label for="title">Τίτλος Εργασίας:</label>
                <textarea id="title" name="title" rows="2" required><?php echo htmlspecialchars($assignment['title'], ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="objectives">Στόχοι Εργασίας:</label>
                <textarea id="objectives" name="objectives" rows="4" required><?php echo htmlspecialchars($assignment['objectives'], ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="deliverables">Παραδοτέα:</label>
                <textarea id="deliverables" name="deliverables" rows="4" required><?php echo htmlspecialchars($assignment['deliverables'], ENT_QUOTES, 'UTF-8'); ?></textarea>

                <label for="due_date">Ημερομηνία Παράδοσης:</label>
                <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($assignment['due_date'], ENT_QUOTES, 'UTF-8'); ?>" required>

                <label for="task_file">Αρχείο Εκφώνησης (PDF/Word):</label>
                <input type="file" id="task_file" name="task_file" accept=".pdf, .doc, .docx">

                <button type="submit" name="update_assignment">Ανανέωση Εργασίας</button>
            </form>
        </div>
    </div>
</body>

</html>
