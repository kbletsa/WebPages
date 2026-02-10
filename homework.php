<?php
require 'db_connect.php';

// Fetch assignments from the database
$stmt = $pdo->prepare("SELECT * FROM assignments ORDER BY due_date ASC");
$stmt->execute();
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
        /* Styling for homework boxes */
        .homework-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .homework-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .homework-box h2 {
            font-size: 20px;
            margin: 0 0 10px;
            color: #333;
        }

        .homework-box p {
            font-size: 16px;
            margin: 0 0 10px;
            color: #555;
        }

        .homework-box small {
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 id="top">Εργασίες</h1>
    </div>
    <div class="container">
        <div class="menu">
            <a href="studentPage.php">Αρχική Σελίδα</a>
            <a href="announcement.php">Ανακοινώσεις</a>
            <a href="communication.php">Επικοινωνία</a>
            <a href="documents.php">Έγγραφα Μαθήματος</a>
            <a href="homework.php">Εργασίες</a>
        </div>
        <div class="main-content">
            <!-- Homework List -->
            <div class="homework-container">
                <?php if ($assignments): ?>
                    <?php foreach ($assignments as $assignment): ?>
                        <div class="homework-box">
                            <h2><?php echo htmlspecialchars($assignment['title']); ?></h2>
                            <p><strong>Στόχοι:</strong> <?php echo htmlspecialchars($assignment['objectives']); ?></p>
                            <p><strong>Αρχείο Εργασίας:</strong> 
                              <a href="<?php echo htmlspecialchars(isset($assignment['task_file']) ? $assignment['task_file'] : '#'); ?>" download>Λήψη Αρχείου</a>
                            <p><strong>Παραδοτέα:</strong> <?php echo htmlspecialchars($assignment['deliverables']); ?></p>
                            <small><strong>Ημερομηνία Παράδοσης:</strong> <?php echo htmlspecialchars($assignment['due_date']); ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Δεν υπάρχουν εργασίες προς εμφάνιση.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>

