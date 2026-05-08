<?php
// We used this to enable strict error reporting so failed queries throw exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// For keeping and storing the user credentials in one place 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  
define('DB_PASS', '');     
define('DB_NAME', 'studentreg_db');

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // This helps us to hide the backend errors to the user at the frontend
    error_log('DB connection failed: ' . $e->getMessage());
    die('A database error occurred. Please try again later.');
}
