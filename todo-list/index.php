<?php
require_once('includes/config.php');
require_once( INCLUDES . '/db.php');
require_once( INCLUDES . '/session.php');
$request = htmlspecialchars($_SERVER['REQUEST_URI']);

function isAuthenticated(){
    if (isset($_SESSION['username'])){
        return true; 
    }
    else{
        return false;
    }
}

function hasAdminRights(){
    $user_id = $_SESSION['user_id'];
    
    $conn = getConnection();

    $stmt = $conn->prepare("SELECT roleID FROM permissions WHERE userId = ?");
    
    $stmt->bind_param("i", $user_id);
    
    $stmt->execute();
    
    $stmt->bind_result($role_id);
    
    if ($role_id == 1) {
        return true;
    } else {
        return false;
    }
}

function redirect($request){
    $pages = array("/login", "/", "/admin/users", "/edit", "/logout");

    if(isAuthenticated())
    {
        header("Location: /");
        exit();
    }else if (in_array($request, $pages)){
        header("Location: /login");
        exit();
    }else{
        require __DIR__ . '/views/error.php';
    }
}


function isValidParameterTasklist($request){
    return match($request){
        '/tasklist/?loading=failed' => true,
        '/tasklist/?update=success' => true,
        '/tasklist/?update=error' => true,
        '/tasklist/?insert=success' => true,
        '/tasklist/?insert=error' => true,
        default => false,
    };
}

function isValidParameterEdit($request){
    if (is_numeric(substr($request, 9)) && str_starts_with($request, '/edit?id=')){
        return true;
    }
    return false;
}

match (true) {
     ($request == '/login' || $request == '/login?failed=1') && !isAuthenticated() => require __DIR__ . '/views/login.php',
     //$request == '/authentication' && isLoggedIn()=> require __DIR__ . '/views/authentication.php',
     $request == '/logout' && isAuthenticated() => require __DIR__ . '/views/logout.php',
     $request == '/users' && isAuthenticated() && hasAdminRights() => require __DIR__ . '/admin/users.php',
     ($request == '/edit' || isValidParameterEdit($request)) && isAuthenticated() => require __DIR__ . '/views/edit.php',
     $request == '/savetask' && isAuthenticated() => require __DIR__ . '/views/savetask.php',
     str_starts_with($request, '/search/v2') && isAuthenticated() => require __DIR__ . '/search/v2/index.php',
     isValidParameterTasklist($request) && isAuthenticated() => require __DIR__ . '/users/tasklist.php', 
     $request == '/' && isAuthenticated() => require __DIR__ . '/views/main.php',
     default => redirect($request),
} 
?>


