<?php
// Include database connection and handling file for add, update, and delete operations
require 'db_connect.php';

// Check if 'id' is passed via URL
if (isset($_GET['id'])) {
    $document_id = intval($_GET['id']);
    
    // Fetch the document data from the database based on the ID
    $stmt = $pdo->prepare("SELECT * FROM documents WHERE id = :id");
    $stmt->bindParam(':id', $document_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $document = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$document) {
        echo "<p>Το έγγραφο δεν βρέθηκε.</p>";
        exit;
    }
} else {
    echo "<p>Μη έγκυρο αναγνωριστικό εγγράφου.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Εγγράφου</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            max-width: 800px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        h1 {
            margin: 0;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 5px;
        }
        
        input[type="text"],
        textarea,
        input[type="file"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        button {
            background-color: #393fe1;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Επεξεργασία Εγγράφου</h1>
        </div>
        <div class="main-content">
            <form action="handling.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="document_id" value="<?php echo $document['id']; ?>">

                <label for="document-title">Τίτλος Εγγράφου:</label>
                <input type="text" id="document-title" name="title" value="<?php echo htmlspecialchars($document['title']); ?>" required>

                <label for="description">Περιγραφή:</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($document['description']); ?></textarea>

                <label for="file">Αρχείο Εγγράφου (PDF/Word):</label>
                <input type="file" id="file" name="file" accept=".pdf, .doc, .docx">
                <p><strong>Ήδη ανεβασμένο αρχείο:</strong> <a href="<?php echo htmlspecialchars($document['file_path']); ?>" download>Λήψη</a></p>

                <button type="submit" name="update_document">Ενημέρωση Εγγράφου</button>
            </form>
        </div>
    </div>
</body>

</html>
