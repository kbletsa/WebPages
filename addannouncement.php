<?php
// Include the database connection
require 'db_connect.php';

// Handle adding an announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if adding an announcement
    if (isset($_POST['subject'], $_POST['content'], $_POST['date'])) {
        $subject = trim($_POST['subject']);
        $content = trim($_POST['content']);
        $date = $_POST['date'];

        // Validate input
        if (empty($subject) || empty($content) || empty($date)) {
            echo "<p>Παρακαλώ συμπληρώστε όλα τα πεδία.</p>";
            exit;
        }

        try {
            // Insert the new announcement into the database
            $stmt = $pdo->prepare("INSERT INTO announcements (date, subject, content) VALUES (:date, :subject, :content)");
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':content', $content);

            if ($stmt->execute()) {
                echo "<p>Η ανακοίνωση προστέθηκε με επιτυχία!</p>";
                header("Location: announcementTutor.php"); // Redirect to announcements page
                exit;
            } else {
                echo "<p>Σφάλμα κατά την προσθήκη της ανακοίνωσης. Παρακαλώ προσπαθήστε ξανά.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Handle removing an announcement
    if (isset($_POST['remove_announcement'], $_POST['announcement_id'])) {
        $announcement_id = $_POST['announcement_id'];

        try {
            // Delete the announcement from the database
            $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = :id");
            $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<p>Η ανακοίνωση αφαιρέθηκε με επιτυχία!</p>";
                header("Location: announcementTutor.php"); // Redirect to announcements page
                exit;
            } else {
                echo "<p>Σφάλμα κατά την αφαίρεση της ανακοίνωσης. Παρακαλώ προσπαθήστε ξανά.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>