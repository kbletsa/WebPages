<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle adding a new announcement
    if (isset($_POST['add_announcement'])) {
        $subject = trim($_POST['subject']);
        $content = trim($_POST['content']);
        $date = $_POST['date'];

        if (empty($subject) || empty($content) || empty($date)) {
            echo "<p>Παρακαλώ συμπληρώστε όλα τα πεδία.</p>";
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO announcements (date, subject, content) VALUES (:date, :subject, :content)");
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':content', $content);

            if ($stmt->execute()) {
                header("Location: announcementTutor.php"); // Redirect to announcements page
                exit;
            } else {
                echo "<p>Σφάλμα κατά την προσθήκη της ανακοίνωσης. Παρακαλώ προσπαθήστε ξανά.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Handle updating an existing announcement
    if (isset($_POST['update_announcement'], $_POST['announcement_id'])) {
        $announcement_id = intval($_POST['announcement_id']);
        $subject = trim($_POST['subject']);
        $content = trim($_POST['content']);
        $date = $_POST['date'];

        if (empty($announcement_id) || empty($subject) || empty($content) || empty($date)) {
            echo "<p>Παρακαλώ συμπληρώστε όλα τα πεδία.</p>";
            exit;
        }

        try {
            $stmt = $pdo->prepare("UPDATE announcements SET subject = :subject, content = :content, date = :date WHERE id = :id");
            $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':date', $date);

            if ($stmt->execute()) {
                header("Location: announcementTutor.php"); // Redirect to announcements page
                exit();
            } else {
                echo "<p>Σφάλμα κατά την ενημέρωση της ανακοίνωσης. Παρακαλώ προσπαθήστε ξανά.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Handle removing an announcement
    if (isset($_POST['remove_announcement'], $_POST['announcement_id'])) {
        $announcement_id = intval($_POST['announcement_id']);

        if (empty($announcement_id)) {
            echo "<p>Μη έγκυρο αναγνωριστικό ανακοίνωσης.</p>";
            exit;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = :id");
            $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: announcementTutor.php"); // Redirect to announcements page
                exit();
            } else {
                echo "<p>Σφάλμα κατά την αφαίρεση της ανακοίνωσης. Παρακαλώ προσπαθήστε ξανά.</p>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


// Handle adding a new document
if (isset($_POST['add_document'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $file_path = $_FILES['file_path'];

    if (empty($title) || empty($description) || empty($file_path)) {
        echo "<p>Παρακαλώ συμπληρώστε όλα τα πεδία.</p>";
        exit;
    }

    // Define file upload directory
    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($file_path['name']);
    
    // Check if the file is valid
    if (move_uploaded_file($file_path['tmp_name'], $upload_dir)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO documents (title, description, file_path) VALUES (:title, :description, :file_path)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':file_path', $upload_dir); // Store the file path in the database

            if ($stmt->execute()) {
                header('Location: documentsTutor.php');
                exit();
            } else {
                echo "Σφάλμα κατά την προσθήκη του εγγράφου στη βάση δεδομένων.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Σφάλμα κατά την αποστολή του αρχείου.";
    }
}



// Handle editing an existing document
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_document'], $_POST['document_id'])) {
    // Retrieve form data
    $document_id = intval($_POST['document_id']); // Ensure document_id is treated as an integer for security
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $file = $_FILES['file']; // New file (optional)

    // Validate title and description fields
    if (empty($title) || empty($description)) {
        echo "<p>Παρακαλώ συμπληρώστε όλα τα πεδία.</p>";
        exit;
    }

    try {
        // Start the transaction to ensure both the document update and file upload (if applicable) are successful
        $pdo->beginTransaction();

        // Update the document title and description in the database
        $stmt = $pdo->prepare("UPDATE documents SET title = :title, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        if (!$stmt->execute()) {
            throw new Exception("Σφάλμα κατά την ενημέρωση του τίτλου και της περιγραφής.");
        }

        // If a new file is uploaded, handle the file update
        if (!empty($file) && $file['error'] === 0) {
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . basename($file['name']);
            
            // Check if file upload is successful
            if (move_uploaded_file($file['tmp_name'], $upload_file)) {
                // Update the file path in the database if the upload was successful
                $stmt = $pdo->prepare("UPDATE documents SET file_path = :file_path WHERE id = :id");
                $stmt->bindParam(':file_path', $upload_file);
                $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
                
                if (!$stmt->execute()) {
                    throw new Exception("Σφάλμα κατά την ενημέρωση του αρχείου.");
                }
            } else {
                throw new Exception("Σφάλμα κατά τη μεταφόρτωση του αρχείου.");
            }
        }

        // Commit the transaction if everything was successful
        $pdo->commit();

        // Redirect to the documents list page
        header('Location: documentsTutor.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        $pdo->rollBack();
        echo "<p>" . $e->getMessage() . "</p>";
    }
}


// Handle deleting a document



session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_assignment'])) {
    $assignment_id = intval($_POST['assignment_id']); // Εξασφαλίζουμε ότι είναι αριθμός

    if ($assignment_id <= 0) {
        echo "<p>Μη έγκυρο αναγνωριστικό εργασίας.</p>";
        exit;
    }

    try {
        // Ανάκτηση του αρχείου της εργασίας
        $stmt = $pdo->prepare("SELECT task_file FROM assignments WHERE id = :id");
        $stmt->bindParam(':id', $assignment_id, PDO::PARAM_INT);
        $stmt->execute();
        $assignment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$assignment) {
            echo "<p>Η εργασία δεν βρέθηκε.</p>";
            exit;
        }

        // Διαγραφή του αρχείου αν υπάρχει
        $filePath = $assignment['task_file'];
        if (!empty($filePath) && file_exists($filePath)) {
            unlink($filePath);
        }

        // Διαγραφή της εργασίας από τη βάση δεδομένων
        $stmt = $pdo->prepare("DELETE FROM assignments WHERE id = :id");
        $stmt->bindParam(':id', $assignment_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: homeworkTutor.php");
            exit();
        } else {
            echo "<p>Σφάλμα κατά τη διαγραφή της εργασίας.</p>";
        }
    } catch (PDOException $e) {
        echo "Σφάλμα: " . $e->getMessage();
    }
}




//αδδ χομγουορκ

if (isset($_POST['add_assignment'])) {
    $title = trim($_POST['title']);
    $objectives = trim($_POST['objectives']);
    $deliverables = trim($_POST['deliverables']);
    $due_date = $_POST['due_date'];
    $task_file = $_FILES['task_file'];

    // Ελέγξτε αν όλα τα πεδία είναι συμπληρωμένα
    if (empty($title) || empty($objectives) || empty($deliverables) || empty($due_date) || empty($task_file)) {
        echo "<p>Παρακαλώ συμπληρώστε όλα τα πεδία.</p>";
        exit;
    }

    
    // Φάκελος αποθήκευσης αρχείων
$upload_dir = 'uploads/';

// Εξασφάλιση ότι ο φάκελος υπάρχει και έχει σωστά δικαιώματα
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Ασφαλές όνομα αρχείου
$filename = time() . "_" . basename($task_file['name']);
$upload_file = $upload_dir . $filename;

// Debugging πληροφορίες
if (!isset($task_file) || $task_file['error'] !== 0) {
    echo "Σφάλμα αρχείου: " . $task_file['error'];
    exit();
}

// Ελεγχος τύπου αρχείου (π.χ. επιτρέπεται μόνο PDF, DOCX, TXT)
$allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];
if (!in_array($task_file['type'], $allowed_types)) {
    echo "Μη επιτρεπτός τύπος αρχείου!";
    exit();
}

// Όριο μεγέθους αρχείου (5MB)
$max_size = 5 * 1024 * 1024;
if ($task_file['size'] > $max_size) {
    echo "Το αρχείο είναι πολύ μεγάλο (μέγιστο: 5MB)!";
    exit();
}

// Μεταφόρτωση αρχείου
if (move_uploaded_file($task_file['tmp_name'], $upload_file)) {
    try {
        // Εισαγωγή εργασίας στη βάση δεδομένων
        $stmt = $pdo->prepare("INSERT INTO assignments (title, objectives, deliverables, due_date, task_file) 
                               VALUES (:title, :objectives, :deliverables, :due_date, :task_file)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':objectives', $objectives);
        $stmt->bindParam(':deliverables', $deliverables);
        $stmt->bindParam(':due_date', $due_date);
        $stmt->bindParam(':task_file', $upload_file);

        if ($stmt->execute()) {
            // Ανακατεύθυνση στη σελίδα των εργασιών
            header("Location: homeworkTutor.php");
            exit();
        } else {
            echo "Σφάλμα κατά την προσθήκη της εργασίας.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Σφάλμα κατά τη μεταφόρτωση του αρχείου.";
}

}



// Handle editing an existing document
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_assignments'], $_POST['assignments_id'])) {
    // Retrieve form data
    $assignments_id = intval($_POST['assignments_id']); // Ensure document_id is treated as an integer for security
    $title = trim($_POST['title']);
    $objectives = trim($_POST['objectives']);
    $deliverables = trim($_POST['deliverables']);
    $due_date = trim($_POST['due_date']);
    $file = $_FILES['file']; // New file (optional)

   

    try {
        // Start the transaction to ensure both the document update and file upload (if applicable) are successful
        $pdo->beginTransaction();

        // Update the document title and description in the database
        $stmt = $pdo->prepare("UPDATE assignments SET title = :title, objectives = :objectives, deliverables = :deliverables, due_date = :due_date WHERE id = :id");
        $stmt->bindParam(':id', $assignments_id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':objectives', $objectives);
        $stmt->bindParam('deliverables', $deliverables);
        $stmt->bindParam('due_date', $due_date);

        if (!$stmt->execute()) {
            throw new Exception("Σφάλμα κατά την ενημέρωση του τίτλου και της περιγραφής.");
        }

        // If a new file is uploaded, handle the file update
        if (!empty($file) && $file['error'] === 0) {
            $upload_dir = 'uploads/';
            $upload_file = $upload_dir . basename($file['name']);
            
            // Check if file upload is successful
            if (move_uploaded_file($file['tmp_name'], $upload_file)) {
                // Update the file path in the database if the upload was successful
                $stmt = $pdo->prepare("UPDATE assignments SET task_file = :task_file WHERE id = :id");
                $stmt->bindParam(':task_file', $upload_file);
                $stmt->bindParam(':id', $assignments_id, PDO::PARAM_INT);
                
                if (!$stmt->execute()) {
                    throw new Exception("Σφάλμα κατά την ενημέρωση του αρχείου.");
                }
            } else {
                throw new Exception("Σφάλμα κατά τη μεταφόρτωση του αρχείου.");
            }
        }

        // Commit the transaction if everything was successful
        $pdo->commit();

        // Redirect to the documents list page
        header('Location: homeworkTutor.php');
        exit();
    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        $pdo->rollBack();
        echo "<p>" . $e->getMessage() . "</p>";
    }

    // Handle Delete Assignment
    if (isset($_POST['delete_assignment'])) {
        if (isset($_POST['assignment_id'])) {
            $assignment_id = $_POST['assignment_id'];

            // Delete the assignment
            $stmt = $pdo->prepare("DELETE FROM assignments WHERE id = :id");
            $stmt->bindParam(':id', $assignment_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: homeworkTutor.php");
                exit();
            } else {
                echo "Σφάλμα κατά τη διαγραφή της εργασίας.";
            }
        } else {
            echo "Σφάλμα: Το αναγνωριστικό εργασίας δεν ορίστηκε.";
        }
    }
}

?>






