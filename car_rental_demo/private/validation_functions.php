<?php
// Checks whether a value is missing or contains only whitespace.
function is_blank($value) {
    return !isset($value) || trim($value) === '';
}

// Checks the minimum and maximum lengths provided by the caller.
function has_length($value, $options) {
    $length = strlen($value);
    if (isset($options['min']) && $length < $options['min']) {
        return false;
    }
    if (isset($options['max']) && $length > $options['max']) {
        return false;
    }
    return true;
}

// Checks the format of an email address.
function has_valid_email_format($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}
