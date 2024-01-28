<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "institute_access";

// Get the entered username and password
$enteredUsername = $_POST['username'];
$enteredPassword = $_POST['password'];

// Create a new MySQLi connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare the SQL statement to fetch the user with the entered username
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $enteredUsername);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verify if the query returned a row
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Verify the entered password against the stored password
    if (isset($user['password']) && $enteredPassword === $user['password']) {
        // Store the username in a session variable
        $_SESSION['username'] = $enteredUsername;

        // Redirect to the student home page or any other desired page
        header('Location: studenthome.php');
        exit();
    }
}

// Invalid username or password
header('Location: index.php?error=1');
exit();

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
