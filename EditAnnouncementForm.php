<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Ανακοίνωσης</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Επεξεργασία Ανακοίνωσης</h1>

        <?php
        require 'db_connect.php';

        // Check if the announcement ID is provided via GET request
        if (isset($_GET['id'])) {
            $announcement_id = $_GET['id'];

            // Prepare and execute the SQL query to fetch the announcement from the database
            $stmt = $pdo->prepare("SELECT * FROM announcements WHERE id = :id");
            $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);
            $stmt->execute();
            $announcement = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($announcement):
        ?>

        <!-- Edit Announcement Form -->
        <form action="handling.php" method="POST">
            <input type="hidden" name="announcement_id" value="<?php echo $announcement['id']; ?>">

            <div class="mb-3">
                <label for="subject" class="form-label">Θέμα</label>
                <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($announcement['subject']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Περιεχόμενο</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($announcement['content']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Ημερομηνία</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $announcement['date']; ?>" required>
            </div>

            <button type="submit" name="update_announcement" class="btn btn-primary">Ανανέωση Ανακοίνωσης</button>
            <a href="announcementTutor.php" class="btn btn-secondary ms-2">Ακύρωση</a>
        </form>

        <?php
            else:
                echo "<p>Η ανακοίνωση δεν βρέθηκε.</p>";
            endif;
        } else {
            echo "<p>Δεν παρέχεται αναγνωριστικό για την ανακοίνωση.</p>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
