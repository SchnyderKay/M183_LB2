<?php
/**
Do all things with logins, database, headers first
*/
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');


/**
Do all things with output last
*/
require_once 'fw/header.php';
?>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php 
if (isset($_SESSION['user_id'])) {
    require_once 'user/tasklist.php';
    echo "<hr />";
    require_once 'user/backgroundsearch.php';
}
?>

<?php
require_once 'fw/footer.php';
?>
