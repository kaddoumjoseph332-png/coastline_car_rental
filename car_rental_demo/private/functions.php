<?php
// Sends visitors without a staff session to the login page.
function require_login() {
    if(!isset($_SESSION['admin_id'])) {
        redirect_to(url_for('/login.php'));
    }
}
// Escapes a value for use in HTML.
function h($string = "") {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

// Encodes a query-string value.
function u($string = "") {
    return urlencode((string)$string);
}

// Encodes a URL path segment.
function raw_u($string = "") {
    return rawurlencode((string)$string);
}

// Builds a link relative to the public directory URL.
function url_for($script_path) {
    if (substr($script_path, 0, 1) != '/') {
        $script_path = "/" . $script_path;
    }
    return PUBLIC_PATH . $script_path;
}

// Sends a location header and stops the current page.
function redirect_to($location) {
    header("Location: " . $location);
    exit;
}

// Checks whether the current request submitted a form.
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Reads a single string value from a form submission.
function form_value($field, $default = '') {
    $value = $_POST[$field] ?? $default;
    return is_string($value) ? $value : $default;
}

// Returns a positive URL id, or zero when the parameter is invalid.
function page_id($field = 'id') {
    $value = $_GET[$field] ?? '';
    if (!is_string($value) || !ctype_digit($value)) {
        return 0;
    }
    return (int)$value;
}
