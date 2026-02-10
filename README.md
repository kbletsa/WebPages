# Dynamic Course Management System

## Project Overview
This project represents Part B of a web development assignment, where a static website was transformed into a fully dynamic educational platform. The system is built using **PHP** and an **SQL database** to handle data management and user interactions.

The platform distinguishes between two user roles—**Tutor** and **Student**—providing different interfaces and functionalities based on authentication.

## Features

### 🔐 Authentication & Security
* **Login System:** Users log in via email and password. The system verifies credentials against the database using `password_verify` and redirects users to their specific dashboard based on their role (`indexTutor.php` for tutors, `index.php` for students).
* **Session Management:** dynamic content display and page redirection.

### 👨‍🏫 Tutor Role (Administrator)
The Tutor interface provides full CRUD (Create, Read, Update, Delete) capabilities:
* **User Management:** Tutors can add new users, as well as search for, edit, and delete existing users via specific forms.
* **Content Management:**
    * **Announcements:** Create, edit, and delete course announcements.
    * **Documents:** Upload, edit, and remove course materials.
    * **Homework:** Manage assignments, including setting objectives and due dates.

### 👨‍🎓 Student Role
The Student interface allows users to consume content created by the tutor:
* **View & Download:** Access to announcements, course documents, and homework assignments.
* **Communication:** A functional contact form to send emails to the tutor or the administration.

## 🗄️ Database Structure
The backend relies on a database (`student4239`) consisting of four main tables:
1.  **users:** Stores id, firstname, lastname, email, password, and role.
2.  **announcements:** Stores subject, date, and content.
3.  **documents:** Stores title, description, and filenames.
4.  **assignments:** Stores objectives, deliverables, due dates, and task files.

## 🚀 Demo Credentials
To test the functionality of the website, you can use the following pre-configured accounts:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Tutor** | `dimos@gmail.com` | `d1234` |
| **Student** | `petros@gmail.com` | `12345` |

The link of the website:
http://kmpletsa.webpages.auth.gr/4239partB
