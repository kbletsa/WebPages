<?php
// Include database connection
require 'db_connect.php';

// Fetch homework assignments from the database
$query = "SELECT * FROM assignments ORDER BY id DESC";
$stmt = $pdo->query($query);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Εργασίες</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .homework-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .homework-box h3 {
            margin-top: 0;
            font-size: 22px;
            color: #333;
        }

        .homework-box p {
            font-size: 16px;
            color: #555;
        }

        .homework-box .buttons {
            margin-top: 10px;
        }

        .homework-box .buttons button,
        .homework-box .buttons a {
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
            padding: 8px 12px;
            transition: background-color 0.3s ease;
        }

        .homework-box .buttons .edit-button {
            background-color: #0056b3;
        }

        .homework-box .buttons .edit-button:hover {
            background-color: ##0056b3;
        }

        .homework-box .buttons .delete-button {
            background-color: #0056b3;
        }

        .homework-box .buttons .delete-button:hover {
            background-color: #0056b3;
        }

        .add-assignment-button {
            margin-bottom: 20px;
        }

        .add-assignment-button button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-assignment-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 id="top">Εργασίες</h1>
    </div>
    <div class="container">
        <div class="menu">
            <a href="indexTutor.php">Αρχική Σελίδα</a>
            <a href="announcementTutor.php">Ανακοινώσεις</a>
            <a href="communicationTutor.php">Επικοινωνία</a>
            <a href="documentsTutor.php">Έγγραφα Μαθήματος</a>
            <a href="homeworkTutor.php">Εργασίες</a>
        </div>
        <div class="main-content">
            <!-- Add New Homework Button -->
            <div class="add-assignment-button">
                <a href="AddHomeworkForm.html">
                    <button>Προσθήκη Νέας Εργασίας</button>
                </a>
            </div>

            <!-- Homework List -->
            <div class="homework-list">
                <?php if ($assignments): ?>
                    <?php foreach ($assignments as $assignment): ?>
                        <div class="homework-box">
                            <h3><?php echo htmlspecialchars(isset($assignment['title']) ? $assignment['title'] : 'No title'); ?></h3>
                            <p><strong>Στόχοι:</strong> <?php echo nl2br(htmlspecialchars(isset($assignment['objectives']) ? $assignment['objectives'] : 'No objectives')); ?></p>
                            <p><strong>Παραδοτέα:</strong> <?php echo nl2br(htmlspecialchars(isset($assignment['deliverables']) ? $assignment['deliverables'] : 'No deliverables')); ?></p>
                            <p><strong>Ημερομηνία Λήξης:</strong> <?php echo htmlspecialchars(isset($assignment['due_date']) ? $assignment['due_date'] : 'No due date'); ?></p>
                            <p><strong>Αρχείο Εργασίας:</strong> 
                                <a href="<?php echo htmlspecialchars(isset($assignment['task_file']) ? $assignment['task_file'] : '#'); ?>" download>Λήψη Αρχείου</a>
                            </p>
                            
                            <!-- Edit and Delete Buttons -->
                            <div class="buttons">

                                <form  action="EditHomeworkForm.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>">
                                    <button type="submit"name="edit_assignment" class="edit-button">Επεξεργασία</button>
                                </form>

                                <form action="handling.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="assignment_id" value="<?php echo $assignment['id']; ?>">
                                    <button type="submit" name="delete_assignment" class="delete-button" onclick="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτήν την εργασία?')">Διαγραφή</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Δεν υπάρχουν εργασίες προς εμφάνιση.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <a href="#top" class="top-link">Επιστροφή στην κορυφή</a>
</body>

</html>

