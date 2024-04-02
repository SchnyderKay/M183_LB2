<?php
$id = 0;
$roleid = 0;
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/header_manipulations.php');

    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $conn = getConnection();
        $stmt = $conn->prepare("select users.id userid, roles.id roleid, roles.title rolename from users inner join permissions on users.id = permissions.userid inner join roles on permissions.roleID = roles.id where userid = ?");
        // If preparing statement fails exit or show error when in debug mode
        if (!$stmt) {
            if(DEBUG) {
                $error = $conn->errno . ' ' . $conn->error;
                echo "<br>".$error;
            }
            exit();
        }
        $stmt->bind_param("s", $id);
        // If statement fails redirect user to login page
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($db_userid, $db_roleid, $db_rolename);
                $stmt->fetch();
                $roleid = $db_roleid;
            }
        }else{
            header("Location: /login.php?failed=1");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBZ 'Secure' App</title>
    <style><?php include 'style.css'?></style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
</head>
<body>
    <header>
        <div>This is the secure m183 test app</div>
        <?php  if (isset($_SESSION['user_id'])) { ?>
        <nav>
            <ul>
                <li><a href="/">Tasks</a></li>
                <?php if ($roleid == 1) { ?>
                    <li><a href="/users">User List</a></li>
                <?php } ?>
                <li><a href="/logout">Logout</a></li>
            </ul>
        </nav>
        <?php  } ?>
    </header>
    <main>