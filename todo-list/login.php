<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username']) && isset($_POST['password'])) {
        // Get username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Sanitize input
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $conn = getConnection();
        // Prepare SQL statement to retrieve user from database
        $stmt = $conn->prepare("SELECT ID, username, password FROM users WHERE username=? AND password=?");
        // If preparing statement fails exit or show error when in debug mode
        if (!$stmt) {
            if(DEBUG) {
                $error = $conn->errno . ' ' . $conn->error;
                echo "<br>".$error;
            }
            exit();
        } else {
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()){
                $stmt->store_result();
                // Check if username exists
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($db_id, $db_username, $db_password);
                    $stmt->fetch();
                    // Verify the password
                    if ($password == $db_password) { // TODO password verification
                        // Password is correct, store username in session
                        session_start();
                        $_SESSION['username'] = $db_username;
                        $_SESSION['user_id'] = $db_id;
                        // Redirect to index.php
                        header("Location: /index.php");
                        exit();
                    } 
                }
            }
            header("Location: /login.php?failed=1");
            exit();
        }
    
    }
require_once 'fw/header.php';
?>

<h2>Login</h2>

<?php if (isset($_GET['failed']) ) { ?>
    <p>Something went wrong. Please try again.</p>
<?php } ?>

<form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control size-medium" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control size-medium" name="password" id="password">
    </div>
    <div class="form-group">
        <label for="submit" ></label>
        <input id="submit" type="submit" class="btn size-auto" value="Login" />
    </div>    
</form>

<?php
require_once 'fw/footer.php';
?>
