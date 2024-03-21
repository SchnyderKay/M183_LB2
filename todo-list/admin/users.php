<?php
require_once(dirname(__DIR__).'/includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');
    //To Do Error Handling
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Prepare SQL statement to retrieve user from database
    $stmtU = $conn->prepare("SELECT users.ID, users.username, roles.title FROM users inner join permissions on users.ID = permissions.userID inner join roles on permissions.roleID = roles.ID order by username");
    // Execute the statement
    $stmtU->execute();
    // Store the result
    $stmtU->store_result();
    // Bind the result variables
    $stmtU->bind_result($db_id, $db_username, $db_title);

    require_once dirname(__DIR__).'/fw/header.php';
?>
<h2>User List</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php
        // Fetch the result
        while ($stmtU->fetch()) {
            echo "<tr><td>$db_id</td><td>$db_username</td><td>$db_title</td></tr>";
        }
    ?>
</table>

<?php
    require_once dirname(__DIR__).'/fw/footer.php';
?>