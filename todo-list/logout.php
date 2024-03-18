<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');

// Unset session variables
unset($_SESSION['username']); 
unset($_SESSION['user_id']); 

// Destroy the session
session_destroy();

// Redirect to the homepage
header("Location: /");
exit();
?>
