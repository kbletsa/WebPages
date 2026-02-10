<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επικοινωνία</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Επικοινωνία</h1>
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
            <div class="content">
                <h2>Αποστολή e-mail μέσω web φόρμας</h2>
                <form>
                    <label for="sender">Αποστολέας:</label>
                    <input type="email" id="sender" name="sender"><br><br>
                    <label for="subject">Θέμα:</label>
                    <input type="text" id="subject" name="subject"><br><br>
                    <label for="message">Κείμενο:</label><br>
                    <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>
                    <button type="submit">Αποστολή</button>
                </form>
            </div>
            <div class="content">
                <h2>Αποστολή e-mail με χρήση e-mail διεύθυνσης</h2>
                <p>Εναλλακτικά μπορείτε να αποστείλετε e-mail στην παρακάτω διεύθυνση ηλεκτρονικού ταχυδρομείου <a href="mailto:@csd.auth.test.gr">@csd.auth.test.gr</a>.</p>
            </div>
            <a href="#top" class="top-link">Επιστροφή στην κορυφή</a>
        </div>
    </div>
</body>

</html>