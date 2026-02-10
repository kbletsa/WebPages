<?php
require 'db_connect.php';

// Fetch documents from the database
$stmt = $pdo->prepare("SELECT * FROM documents ORDER BY title ASC");
$stmt->execute();
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Έγγραφα Μαθήματος</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styling for document boxes */
        .document-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }

        .document-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .document-box h2 {
            font-size: 20px;
            margin: 0 0 10px;
            color: #333;
        }

        .document-box p {
            font-size: 16px;
            margin: 0 0 10px;
            color: #555;
        }

        .document-box small {
            font-size: 14px;
            color: #888;
        }

        .document-box a {
            font-size: 16px;
            color: #0066cc;
            text-decoration: none;
        }

        .document-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 id="top">Έγγραφα Μαθήματος</h1>
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
            <!-- Documents List -->
            <div class="document-container">
                <?php if ($documents): ?>
                    <?php foreach ($documents as $document): ?>
                        <div class="document-box">
                            <h2><?php echo htmlspecialchars($document['title']); ?></h2>
                            <p><?php echo htmlspecialchars($document['description']); ?></p>
                            <p><strong>Αρχείο:</strong> <a href="<?php echo htmlspecialchars($document['file_path']); ?>" download>Λήψη</a></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Δεν υπάρχουν έγγραφα προς εμφάνιση.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript for Fetching Documents -->
    <script>
        window.onload = function() {
            fetchData('documents'); // Fetch documents data
        };

        function fetchData(type) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch.php?type=" + type, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById("documents-list").innerHTML = xhr.responseText;
                } else {
                    console.error("Error fetching data for type: " + type);
                }
            };
            xhr.send();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <a href="#top" class="top-link">Επιστροφή στην κορυφή</a>
</body>

</html>

