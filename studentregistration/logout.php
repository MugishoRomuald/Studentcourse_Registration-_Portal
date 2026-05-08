<?php
session_start();
session_unset();     // We used it to help us clear all the session variables at first
session_destroy();   // we used it to destroy the session
header('Location: login.php');
exit;
