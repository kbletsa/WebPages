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
        .announcement-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .announcement-box h2 {
            margin-top: 0;
            font-size: 22px;
            color: #333;
        }

        .announcement-box p {
            font-size: 16px;
            color: #555;
        }

        .announcement-box small {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #777;
        }

        .announcement-box .buttons {
            margin-top: 15px;
        }

        .announcement-box .buttons button,
        .announcement-box .buttons a {
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
            padding: 8px 12px;
            transition: background-color 0.3s ease;
        }

        .announcement-box .buttons .edit-button {
            background-color: #0056b3;
        }

        .announcement-box .buttons .edit-button:hover {
            background-color: #0056b3;
        }

        .announcement-box .buttons .delete-button {
            background-color: #0056b3;
        }

        .announcement-box .buttons .delete-button:hover {
            background-color: #0056b3;
        }

        .add-announcement-button {
            margin-bottom: 20px;
        }

        .add-announcement-button button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-announcement-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Ανακοινώσεις</h1>
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
            <!-- Add New Announcement Button -->
            <div class="add-announcement-button">
                <a href="AddAnnouncementForm.html">
                    <button>Προσθήκη Νέας Ανακοίνωσης</button>
                </a>
            </div>

            <!-- Announcements List -->
            <div class="announcements-list">
                <?php if ($announcements): ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="announcement-box">
                            <h2><?php echo htmlspecialchars($announcement['subject']); ?></h2>
                            <p><?php echo nl2br(htmlspecialchars($announcement['content'])); ?></p>
                            <small>Ημερομηνία: <?php echo htmlspecialchars($announcement['date']); ?></small>
                            
                            <!-- Edit and Delete Buttons -->
                            <div class="buttons">
                                <form action="handling.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="announcement_id" value="<?php echo $announcement['id']; ?>">
                                    <button type="submit" name="remove_announcement" class="delete-button">Αφαίρεση Ανακοίνωσης</button>
                                </form>

                                <a href="EditAnnouncementForm.php?id=<?php echo $announcement['id']; ?>">
                                    <button type="button" class="edit-button">Επεξεργασία Ανακοίνωσης</button>
                                </a>
                            </div>
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

