<?php
require 'db_connect.php'; // Include the database connection

// Check the type of request (documents, assignments, or announcements)
if (isset($_GET['type'])) {
    $type = $_GET['type'];

    try {
        if ($type === 'documents') {
            // Fetch documents from the database
            $stmt = $pdo->query("SELECT * FROM documents ORDER BY title ASC"); // Fetch documents ordered by title
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($documents) {
                foreach ($documents as $document) {
                    echo "<div class='module card shadow-sm mb-3'>";
                    echo "<div class='card-body'>";
                    echo "<h2>" . htmlspecialchars($document['title']) . "</h2>";
                    echo "<p><strong>Περιγραφή:</strong> " . htmlspecialchars($document['description']) . "</p>";
                    echo "<a href='" . htmlspecialchars($document['file_path']) . "' class='btn btn-primary' download>Κατέβασμα Εγγράφου</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Δεν υπάρχουν έγγραφα προς εμφάνιση.</p>";
            }
        } elseif ($type === 'assignments') {
            // Fetch assignments from the database
            $stmt = $pdo->query("SELECT * FROM assignments ORDER BY due_date ASC"); // Fetch assignments ordered by due date
            $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($assignments) {
                foreach ($assignments as $assignment) {
                    echo "<div class='module card shadow-sm mb-3'>";
                    echo "<div class='card-body'>";
                    echo "<h2>" . htmlspecialchars($assignment['objectives']) . "</h2>";
                    echo "<p><strong>Στόχοι:</strong><br>";
                    echo nl2br(htmlspecialchars($assignment['objectives'])) . "</p>";
                    echo "<p><strong>Εκφώνηση:</strong><br> Κατεβάστε την εκφώνηση της εργασίας από εδώ:</p>";
                    echo "<a href='" . htmlspecialchars($assignment['task_file']) . "' class='btn btn-primary' download>Κατέβασμα Εκφώνησης</a>";
                    echo "<p><strong>Παραδοτέα:</strong><br>" . htmlspecialchars($assignment['deliverables']) . "</p>";
                    echo "<p><strong>Ημερομηνία Παράδοσης:</strong> " . htmlspecialchars($assignment['due_date']) . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Δεν υπάρχουν εργασίες προς εμφάνιση.</p>";
            }
        } elseif ($type === 'announcements') {
            // Fetch announcements from the database
            $stmt = $pdo->query("SELECT * FROM announcements ORDER BY date DESC"); // Fetch announcements ordered by date
            $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($announcements) {
                foreach ($announcements as $announcement) {
                    echo "<div class='announcement'>";
                    echo "<h2>" . htmlspecialchars($announcement['subject']) . "</h2>";
                    echo "<p>" . htmlspecialchars($announcement['content']) . "</p>";
                    echo "<small>Ημερομηνία: " . htmlspecialchars($announcement['date']) . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>Δεν υπάρχουν ανακοινώσεις προς εμφάνιση.</p>";
            }
        } else {
            echo "Invalid request type.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No type specified.";
}
?>