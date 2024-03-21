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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBZ 'Secure' App</title>
    <style><?php include 'fw/style.css'?></style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
</head>
<body>
    <header>
        <div>This is the insecure m183 test app</div>
        <?php  if (isset($_SESSION['user_id'])) { ?>
        <nav>
            <ul>
                <li><a href="/">Tasks</a></li>
                <?php if ($roleid == 1) { ?>
                    <li><a href="/admin/users">Users</a</li>
                <?php } ?>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
        <?php  } ?>
    </header>
    <main>
        <h2>Error, page not found please return to <a href="/">Home</a></h2>

<?php
require_once 'fw/footer.php';
?>