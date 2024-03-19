<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');

    $conn = getConnection();

    $userid = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT ID, title, state FROM tasks WHERE userID = ?");

    if($stmt){
        $stmt->bind_param("i", $userid);

        if($stmt->execute()){
                $stmt->store_result();

                $stmt->bind_result($db_id, $db_title, $db_state);
        } else {
            if(DEBUG) {
                $error = $conn->errno . ' ' . $conn->error;
                echo "<br>".$error;
            }
            header("Location: tasklist/?loading=failed");
            exit();
        }
    } else {
        if(DEBUG) {
            $error = $conn->errno . ' ' . $conn->error;
            echo "<br>".$error;
        }
        header("Location: tasklist/?loading=failed");
        exit();
    }
   
?>
<?php if (isset($_GET['failed']) ) { ?>
    <p>Something went wrong while loading tasks. Please try again.</p>
<?php } ?>
<section id="list">
<?php
if (isset($_GET['insert']) && $_GET['insert'] === 'success') {
    echo "<span class='info info-success'>Insert successful</span>";
} elseif (isset($_GET['insert']) && $_GET['insert'] === 'error') {
    echo "<span class='info info-error'>Error inserting task</span>";
}

if (isset($_GET['update']) && $_GET['update'] === 'success') {
    echo "<span class='info info-success'>Update successful</span>";
} elseif (isset($_GET['update']) && $_GET['update'] === 'error') {
    echo "<span class='info info-error'>Error updating task</span>";
}
?>
    <a href="edit.php">Create Task</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>State</th>
            <th></th>
        </tr>
        <?php while ($stmt->fetch()) { ?>
            <tr>
                <td><?php echo $db_id ?></td>
                <td class="wide"><?php echo $db_title ?></td>
                <td><?php echo ucfirst($db_state) ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $db_id ?>">edit</a> | <a href="delete.php?id=<?php echo $db_id ?>">delete</a>
                </td>
            </tr>
        <?php } ?>        
    </table>
</section>