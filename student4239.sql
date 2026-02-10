-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: webpagesdb.it.auth.gr:3306
-- Χρόνος δημιουργίας: 16 Ιαν 2025 στις 22:35:19
-- Έκδοση διακομιστή: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- Έκδοση PHP: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `student4239`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `announcements`
--

INSERT INTO `announcements` (`id`, `date`, `subject`, `content`) VALUES
(8, '2024-12-17', 'Αίτηση Πτυχιακής', 'Οι φοιτητές που επιθυμούν να εκπνοήσουν πτυχιακή εργασία να στείλουν μήνυμα στον διδάσκοντα'),
(11, '2025-01-15', 'Eξεταζομενο εργαστηριο', 'Το εξεταζόμενο εργαστήριο του μαθήματος θα πραγματοποιηθεί στις 20 Ιανουαρίου');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `objectives` text NOT NULL,
  `task_file` varchar(255) NOT NULL,
  `deliverables` text,
  `due_date` date NOT NULL,
  `title` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `assignments`
--

INSERT INTO `assignments` (`id`, `objectives`, `task_file`, `deliverables`, `due_date`, `title`) VALUES
(8, 'Κατασκευή σωρού ελαχίστων...', 'uploads/ergasia1 (2).doc', 'Πηγαίος κώδικας...', '2025-01-26', 'Εργασία 1'),
(9, 'Εμβάθυνση στη θεωρία...', 'uploads/ergasia1 (2).doc', 'Υποβολή αναφοράς...', '2025-02-09', 'Εργασία 2');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `file_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `documents`
--

INSERT INTO `documents` (`id`, `title`, `description`, `file_path`) VALUES
(8, 'Πολυπλοκότητα Αλγορίθμων', 'Διαφάνειες και σημειώσεις του μαθήματος', 'uploads/01.Εισαγωγή στο Android.pdf'),
(10, 'Δέντρα και Γράφοι', 'Δυαδικά δέντρα...', 'uploads/02.Σχεδιασμός UI σε Android Apps (3).pdf');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Tutor','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `role`) VALUES
(9, 'billl', 'tsit', 'billytsitotas@gmail.com', '123', 'Tutor'),
(10, 'maria', 'papadopoyloy', 'mariapap@gmail.com', 'maria', 'Student'),
(11, 'kleopatra', 'theologou', 'kleo@gmail.com', '123456789', 'Student'),
(12, 'giorgos', 'papatheodorou', 'george@gmail.com', 'g123', 'Student'),
(13, 'Dimos', 'Mpletsas', 'dimos@gmail.com', 'd1234', 'Tutor'),
(14, 'petros', 'alexiouu', 'petros@gmail.com', '12345', 'Student');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT για πίνακα `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT για πίνακα `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
