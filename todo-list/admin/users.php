<?php
require_once('../includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');
    //To Do Error Handling
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT users.ID, users.username, users.password, roles.title FROM users inner join permissions on users.ID = permissions.userID inner join roles on permissions.roleID = roles.ID order by username");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_id, $db_username, $db_password, $db_title);

    require_once '../fw/header.php';
?>
<h2>User List</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php
        while ($stmt->fetch()) {
            echo "<tr><td>htmlspecialchars($db_id)</td><td>htmlspecialchars($db_username)</td><td>htmlspecialchars($db_title)</td><input type='hidden' name='password' value='htmlspecialchars($db_password)' /></tr>";
        }
    ?>
</table>

<?php
    require_once '../fw/footer.php';
?>