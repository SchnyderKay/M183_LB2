<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');

    $conn = getConnection();
    $taskid = "";

    // see if the id exists in the database

    if (isset($_POST['id']) && strlen($_POST['id']) != 0){
        $taskid = $_POST["id"];
        //$stmt = executeStatement("select ID, title, state from tasks where ID = $taskid");
        $stmt = $conn->prepare("select ID, title, state from tasks where ID = ?");
        $stmt->bind_param("s", $_POST['id']);
        $stmt->execute();
        if ($stmt->num_rows == 0) {
            $taskid = "";
        }
    }
  
  if (isset($_POST['title']) && isset($_POST['state'])){
    
    // Sanitize input
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);

    // Check if user_id is set in $_SESSION
    if (isset($_SESSION['user_id'])) {
        $userid = $_SESSION['user_id'];
        $conn = getConnection();


        if ($taskid == "") {
        $stmt = $conn->prepare("INSERT INTO tasks (title, state, userID) VALUES (?, ?, ?)");
        if (!$stmt) {
            if(DEBUG) {
                $error = $conn->errno . ' ' . $conn->error;
                echo "<br>".$error;
            }
            exit();
        }

        $stmt->bind_param("ssi", $title, $state, $userid);
        if ($stmt->execute()) {
            header("Location: /?insert=success");
            exit();
        } else {
            header("Location: /?insert=error");
            exit();
        }
    } else {
        $stmt = $conn->prepare("UPDATE tasks SET title = ?, state = ? WHERE ID = ? AND userID = ?");
        $stmt->bind_param("ssii", $title, $state, $taskid, $userid);
        if ($stmt->execute()) {
            header("Location: /?update=success");
            exit();
        } else {
            header("Location: /?update=error");
            exit();
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
