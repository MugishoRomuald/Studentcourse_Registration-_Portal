# Umoja Student Course Registration Portal

A lightweight and functional PHP/MySQL web application designed for academic course management and student enrollment.

## Login Credentials 
To login as an Admin, use the below
**admin email (`mugishomunganga@gmail.com`)**
# admin password (`mugisho`)
## student Login credentials
**email(`ssemogerere@gmail.com`)**
**password(`12345678`)
## Features

### For Students
* **Course Discovery:** Search for courses by name or code.
* **Easy Enrollment:** Simple one-click enrollment with built-in duplicate prevention (`INSERT IGNORE`).
* **My Courses:** A dedicated view (`enrolled.php`) to track all active course registrations.

### For Admins
* **Insightful Dashboard:** Real-time platform statistics including total students, courses, and enrollments.
* **Course Management (CRUD):** Full capability to add, edit, and delete course listings through a secure interface.
* **Secure Registration:** Admin account creation is protected by a mandatory **Secret Key**.


## Tech Stack
* **Backend:** PHP (Sessions, MySQLi Prepared Statements)
* **Database:** MySQL
* **Frontend:** Bootstrap 5 (through CDN), HTML5, CSS3, JavaScript
* **Security:** Password hashing (`password_hash`), CSRF Protection for deletions, and SQL Injection prevention.


##  Installation and Setup

1. **Clone/Move the Project:**
   Place the project folder in your local server directory (e.g., `htdocs` for XAMPP or `www` for WAMP).

2. **Database Configuration:**
   - Open your MySQL administration tool (e.g., **phpMyAdmin**).
   - Create a new database named `studentreg_db`.
   - Import the `studentreg_db.sql` file provided in the repository.

3. **Connection Settings:**
   Open `db.php` and verify the credentials match your local environment:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'studentreg_db');
   ```

4. **Launch:**
   Navigate to `http://localhost/studentregistration/index.php` in your web browser.


##  Admin Access
To register as an **Administrator**, enter the following key in the registration form:
**Admin Secret Key:** `mugisho`


## Security and Design Notes
* **Data Integrity:** A unique composite key on `registrations(user_id, course_id)` ensures data consistency.
* **Access Control:** The system checks session roles and redirects unauthorized users to `login.php`.
* **POST-Only Actions:** Critical actions like `delete.php` are restricted to **POST** requests and verified with **CSRF tokens**.





