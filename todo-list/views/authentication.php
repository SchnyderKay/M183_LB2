<?php
require_once dirname(__DIR__).'/vendor/autoload.php';
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');


use RobThree\Auth\TwoFactorAuth;

    // Check if the form is submitted
    // Connect to the database
    $conn = getConnection();
    $username = $_SESSION['username'];
    $tfa = new TwoFactorAuth();

    // Prepare SQL statement to retrieve user from database
    $stmt = $conn->prepare("SELECT id, secret, temp_secret FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username); 
            if($stmt->execute()){
            // Store the result
            $stmt->store_result();
            // Check if username exists
            if ($stmt->num_rows > 0) {
                // Bind the result variables
                $stmt->bind_result($user_id, $secret, $temp_secret);
                // Fetch the result
                $stmt->fetch();
                $verification_secret = ($secret == 0 ? $temp_secret : $secret);
            } else {
                // Username does not exist
                echo "Username does not exist";
            }
        }else{
            errorHandlingPreparedStatement();
        }   
    } else {
        errorHandlingPreparedStatement();
    } 


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verification'])) {
        // Get username and password from the form
        $verification = $_POST['verification'];

        try {
            if ($tfa->verifyCode($verification_secret, $verification) === true){
                $stmt = $conn->prepare("UPDATE users SET secret = ? WHERE ID = ?");
                $stmt->bind_param("si", $verification_secret, $user_id);
                $stmt->execute();
                $stmt = $conn->prepare("UPDATE users SET temp_secret = NULL WHERE ID = ?");
                $stmt->bind_param("i", $user_id); 
                $stmt->execute();
                $_SESSION['user_id'] = $user_id;
                header("Location: /");
                exit(); 
            }
            else {
                $stmt = $conn->prepare("UPDATE users SET temp_secret = NULL WHERE ID = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                unset($_SESSION['username']); 
                echo "<script>
                    alert('Authentication failed please try again.');
                    window.location.href='/login';
                    </script>";
            }
        } catch (Exception $e) {
            $stmt = $conn->prepare("UPDATE users SET temp_secret = NULL WHERE ID = ?");
            $stmt->bind_param("i", $user_id); 
            $stmt->execute();
            unset($_SESSION['username']); 
            echo "<script>
                alert('Authentication failed please try again.');
                window.location.href='/login';
                </script>";
        }
    
    }
    require_once 'fw/header.php';
    ?>

        <h2>2Factor Authentication</h2>
        <div id="authentication">
            <?php
                if ($secret == null){
                    $verification_secret = $tfa->createSecret();
                    $stmt = $conn->prepare("UPDATE users SET temp_secret = ? WHERE ID = ?");
                    $stmt->bind_param("si", $verification_secret, $user_id); 
                    $stmt->execute();
                    ?>
                    <p> Scan with Microsoft Authenticator</p>
                    <img src="<?php echo $tfa->getQRCodeImageAsDataUri('LB02', $verification_secret); ?>"><br>
                    <p>Or enter the code manually</p>
                    <?php echo chunk_split($verification_secret, 4, ' '); 
                }
            ?>
        </div>
        <form id="form" method="post" action="#">
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