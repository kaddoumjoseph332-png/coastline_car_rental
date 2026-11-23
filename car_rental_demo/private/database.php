<?php
// Opens the MySQL connection using the private configuration.
function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if (!$connection) {
        http_response_code(500);
        exit('Database connection failed. Check the local database settings.');
    }
    return $connection;
}

// Closes the connection at the end of a page.
function db_disconnect($connection) {
    mysqli_close($connection);
}

// Escapes a string before it is quoted in SQL.
function db_escape($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
}

// Stops rendering if a SELECT failed.
function confirm_result_set($result_set) {
    if (!$result_set) {
        http_response_code(500);
        exit('Could not read the database.');
    }
}
