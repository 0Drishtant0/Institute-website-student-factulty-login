<?php
// Check if the noteId is provided
if (isset($_POST['noteId'])) {
    $noteId = $_POST['noteId'];

    // Database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "institute_access";

    // Create a new MySQLi instance
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to fetch the note content
    $stmt = $conn->prepare("SELECT content FROM notes WHERE id = ?");
    $stmt->bind_param("i", $noteId);
    $stmt->execute();
    $stmt->bind_result($noteContent);

    // Fetch the note content
    if ($stmt->fetch()) {
        // Display the note content
        echo $noteContent;
    } else {
        echo "Note content not found";
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
