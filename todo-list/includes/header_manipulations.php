<?php

// Disable X-Powered-By header
header_remove("X-Powered-By");

// Disable Server header
header_remove("Server");

// Set Content-Type header for HTML
header("Content-Type: text/html; charset=UTF-8");

// Set X-Content-Type-Options header to prevent MIME-sniffing
header("X-Content-Type-Options: nosniff");

// Set CSP to limit and specify resource loading for security
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js; style-src 'self'");
