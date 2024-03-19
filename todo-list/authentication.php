<?php
require 'vendor/autoload.php';
require_once 'config.php';
require_once 'fw/db.php';

use RobThree\Auth\TwoFactorAuth;

// Check if the form is submitted
// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$username = $_COOKIE['username'];
$tfa = new TwoFactorAuth();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Prepare SQL statement to retrieve user from database
$stmt = $conn->prepare("SELECT id, secret FROM users WHERE username='$username'");
// Execute the statement
$stmt->execute();
// Store the result
$stmt->store_result();
// Check if username exists
if ($stmt->num_rows > 0) {
    // Bind the result variables
    $stmt->bind_result($user_id, $secret);
    // Fetch the result
    $stmt->fetch();
    // Verify the password
    
} else {
    // Username does not exist
    echo "Username does not exist";
}

// Close statement
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['verification'])) {
    // Get username and password from the form
    $verification = $_GET['verification'];
    #$code = $tfa->getCode($secret);

    try {
        if ($tfa->verifyCode($secret, $verification) === true){
            header("Location: index.php");
            exit(); 
        }
        else {
            echo '<script>alert("Authentication failed.")</script>';
            header("Location: logout.php");
            exit(); 
        }
    } catch (Exception $e) {
        echo '<script>alert("Something went wrong please try again.")</script>';
        header("Location: logout.php");
        exit(); 
    }
    
}
require_once 'fw/header.php';
?>

    <h2>2Factor Authentication</h2>
    <div id="authentication">
        <?php
            if ($secret == 0){
                $secret = $tfa->createSecret();
                $stmt = executeStatement("update users set secret = '$secret' where ID = $user_id");
                ?>
                <p> Scan with Microsoft Authenticator</p>
                <img src="<?php echo $tfa->getQRCodeImageAsDataUri('Demo', $secret); ?>"><br>
                <p>Or enter the code manually</p>
                <?php echo chunk_split($secret, 4, ' '); 
            }
        ?>
    </div>
    <form id="form" method="get" action="<?php $_SERVER["PHP_SELF"]; ?>">
    <div class="form-group">
        <label for="secret">Verification code </label>
        <input input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;" required type="number" class="form-control size-medium" name="verification" id="verification">
    </div>
    <div class="form-group">
        <label for="submit" ></label>
        <input id="submit" type="submit" class="btn size-auto" value="Authenticate" />
    </div>    
</form>

<?php
    require_once 'fw/footer.php';
?>