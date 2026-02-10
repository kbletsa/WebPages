<?php
require 'db_connect.php';

// Fetch announcements from the database
$stmt = $pdo->prepare("SELECT * FROM announcements ORDER BY date DESC");
$stmt->execute();
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ανακοινώσεις</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic styling for announcement boxes */
        .announcement-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .announcement-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .announcement-box h2 {
            font-size: 20px;
            margin: 0 0 10px;
            color: #333;
        }

        .announcement-box p {
            font-size: 16px;
            margin: 0 0 10px;
            color: #555;
        }

        .announcement-box small {
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Ανακοινώσεις</h1>
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
            <div class="announcement-container">
                <?php if ($announcements): ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="announcement-box">
                            <h2><?php echo htmlspecialchars($announcement['subject']); ?></h2>
                            <p><?php echo htmlspecialchars($announcement['content']); ?></p>
                            <small>Ημερομηνία: <?php echo htmlspecialchars($announcement['date']); ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Δεν υπάρχουν ανακοινώσεις προς εμφάνιση.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
