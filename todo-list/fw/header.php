<?php
$id = 0;
$roleid = 0;
// require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    
    $conn = getConnection();
    // Prepare SQL statement to retrieve user from database
    $stmt = $conn->prepare("select users.id userid, roles.id roleid, roles.title rolename from users inner join permissions on users.id = permissions.userid inner join roles on permissions.roleID = roles.id where userid = ?");

    // Bind parameters and execute the statement
    $stmt->bind_param("s", $id);
    $stmt->execute(); // TODO check for error here

    // Store the result
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_userid, $db_roleid, $db_rolename);
        $stmt->fetch();
        $roleid = $db_roleid;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBZ 'Secure' App</title>
    <link rel="stylesheet" href="/fw/style.css" />
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
                    <li><a href="/admin/users.php">User List</a></li>
                <?php } ?>
                <li><a href="/logout.php">Logout</a></li>
            </ul>
        </nav>
        <?php  } ?>
    </header>
    <main>