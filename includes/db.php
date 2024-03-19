<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "Cgame";

// Create database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute SQL queries
function execute_query($sql) {
    global $conn;
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result;
}

// Function to fetch a single row from the database
function fetch_row($sql) {
    $result = execute_query($sql);
    return $result->fetch_assoc();
}

// Function to fetch multiple rows from the database
function fetch_rows($sql) {
    $result = execute_query($sql);
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}

// Function to insert data into the database
function insert_data($sql) {
    execute_query($sql);
    return mysqli_insert_id($GLOBALS['conn']);
}

// Function to escape strings to prevent SQL injection
function escape_string($string) {
    global $conn;
    return $conn->real_escape_string($string);
}

// Close database connection
function close_connection() {
    global $conn;
    $conn->close();
}
