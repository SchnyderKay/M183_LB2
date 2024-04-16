<?php
session_start(); // Start the session

// Disable X-Powered-By header
header_remove("X-Powered-By");

// Disable Server header
header_remove("Server");

// Set X-Content-Type-Options header to prevent MIME-sniffing
header("X-Content-Type-Options: nosniff");

