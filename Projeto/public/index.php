<?php
// Include the necessary configuration file two levels up from the current file.
require_once(dirname(__FILE__, 2) . '/src/config/config.php');

// Decode and parse the URL path from the REQUEST_URI server variable.
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Check if the URI is '/', empty, or '/index.php'.
if($uri === '/' || $uri === '' ||  $uri === '/index.php') {
    // If it matches one of these conditions, set the URI to '/day_records.php'.
    $uri = '/day_records.php';
}

// Include the controller file based on the modified URI.
require_once(CONTROLLER_PATH . "/{$uri}");
