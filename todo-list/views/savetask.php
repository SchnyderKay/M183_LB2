<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');

    $conn = getConnection();
    $taskid = "";

    // see if the id exists in the database
    if (isset($_POST['id']) && strlen($_POST['id']) != 0){
        $taskid = $_POST['id'];
        $stmt = $conn->prepare("select ID, title, state from tasks where ID = ?");

        // If preparing the statement fails exit or show error when in debug mode
        if ($stmt) {
            $stmt->bind_param("i", $taskid);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    $taskid = "";
                }
            } else {
                errorHandlingPreparedStatement();
            }
        } else {
            errorHandlingPreparedStatement();
        }
       
    }
  
  if (isset($_POST['title']) && isset($_POST['state'])){
    // Sanitize input
    $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $state = filter_var($_POST['state'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if user_id is set in $_SESSION
    if (isset($_SESSION['user_id'])) {
        $userid = $_SESSION['user_id'];
        $conn = getConnection();
        if ($taskid == "") {
            $stmt = $conn->prepare("INSERT INTO tasks (title, state, userID) VALUES (?, ?, ?)");

            // If preparing the statement fails exit or show error when in debug mode
            if ($stmt) {
                $stmt->bind_param("ssi", $title, $state, $userid);
                if ($stmt->execute()) {
                    header("Location: /tasklist/?insert=success");
                    exit();
                } else {
                    header("Location: /tasklist/?insert=error");
                    exit();
                }
            } else {
                errorHandlingPreparedStatement($stmt);
            }
        } else {
            $stmt = $conn->prepare("UPDATE tasks SET title = ?, state = ? WHERE ID = ? AND userID = ?");

            // If preparing the statement fails exit or show error when in debug mode
            if ($stmt) {
                $stmt->bind_param("ssii", $title, $state, $taskid, $userid);

                // Check if execution successful
                if ($stmt->execute()) {
                    header("Location: /tasklist/?update=success");
                    exit();
                } else {
                    header("Location: /tasklist/?update=error");
                    exit();
                }
            } else {
                errorHandlingPreparedStatement($stmt);
            }
        }
    }
  }
  else {
    echo "<span class='info info-error'>No update was made</span>";
  } 
  require_once 'fw/header.php';
  require_once 'fw/footer.php';
?>
