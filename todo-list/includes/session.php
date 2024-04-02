<?php
session_start(); // Start the session
$params = session_get_cookie_params();
setcookie("PHPSESSID", session_id(), 0, $params["path"], $params["domain"],
    false,  // this is the secure flag you need to set. Default is false.
    true); // this is the httpOnly flag you need to set

// Disable X-Powered-By header
header_remove("X-Powered-By");

// Disable Server header
header_remove("Server");

// Set Content-Type header for HTML
header("Content-Type: text/html; charset=UTF-8");

// Set X-Content-Type-Options header to prevent MIME-sniffing
header("X-Content-Type-Options: nosniff");