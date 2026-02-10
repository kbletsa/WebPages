<?php
// Include database connection and handling file for add, update, and delete operations
require 'db_connect.php'; 
include 'handling.php'; 

// Fetch all documents
$stmt = $pdo->query("SELECT * FROM documents ORDER BY id DESC");
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Έγγραφα Μαθήματος</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .document {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        .document h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        .document p {
            font-size: 16px;
            color: #555;
        }

        .document .buttons {
            margin-top: 10px;
        }

        .document .buttons button,
        .document .buttons a {
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .document .buttons button:hover,
        .document .buttons a:hover {
            background-color: #0056b3;
        }

        .add-document-button {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 id="top">Έγγραφα Μαθήματος</h1>
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
            <!-- Add New Document Button -->
            <div class="add-document-button">
                <a href="AddDocumentForm.html">
                    <button>Προσθήκη Νέου Εγγράφου</button>
                </a>
            </div>

            <!-- Documents List -->
            <div class="documents-list">
                <?php if ($documents): ?>
                    <?php foreach ($documents as $document): ?>
                        <div class="document">
                            <h2><?php echo htmlspecialchars($document['title']); ?></h2>
                            <p><strong>Περιγραφή:</strong> <?php echo htmlspecialchars($document['description']); ?></p>
                            <p><strong>Αρχείο:</strong> <a href="<?php echo htmlspecialchars($document['file_path']); ?>" download>Λήψη</a></p>
                            <div class="buttons">
                            <div class="buttons">
                            <!-- Edit Document -->
                            <form action="EditDocumentForm.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                                <button type="submit">Επεξεργασία</button>
                            </form>

                                <!-- Delete Document -->
                                <form action="documentsTutor.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="remove_document" value="1">
                                    <input type="hidden" name="document_id" value="<?php echo $document['id']; ?>">
                                    <button type="submit" onclick="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε το έγγραφο;')">Διαγραφή</button>
                                </form>
                            </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Δεν υπάρχουν έγγραφα για εμφάνιση.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Back to Top Link -->
    <a href="#top" class="top-link">Επιστροφή στην κορυφή</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
