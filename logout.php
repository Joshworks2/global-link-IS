<?php
session_start();
session_unset();   // clear all session variables
session_destroy(); // destroy the session

// redirect to login page with logout message
header("Location: login.php?logout=1");
exit();
?>
