<?php
require_once('../../includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');

    $conn = getConnection();


    if (!isset($_POST["userid"]) || !isset($_POST["terms"])){
        exit("Not enough information to search");
    }

    if ($_POST["userid"] != $_SESSION['user_id']) {
        exit("Unauthorized search");
    }

    // Sanitize input
    $userid = filter_var($_POST['userid'], FILTER_SANITIZE_STRING);
    $terms = filter_var($_POST['terms'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("select ID, title, state from tasks where userID = ? and title like ?");

    $terms = '%' . $terms . '%';
    $stmt->bind_param("ss", $userid, $terms);

    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_id, $db_title, $db_state);
        while ($stmt->fetch()) {
            echo htmlspecialchars($db_title) . ' (' . htmlspecialchars($db_state) . ')<br />';
        }
    }
?>