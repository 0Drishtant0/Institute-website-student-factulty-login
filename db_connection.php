<?php

// Function to open a database connection
function openDatabaseConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "institute_access";

    // Create a new MySQLi object
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

?>
