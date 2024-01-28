<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "institute_access";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verify login credentials
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query
    $query = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        if ($password === $storedPassword) {
            // Passwords match, login successful
            // Redirect or perform any further actions
            echo "success";
        } else {
            // Passwords do not match, login failed
            echo "Failure";
        }
    } else {
        // User not found in the database, login failed
        echo "Failure";
    }
}

// Close the database connection
mysqli_close($conn);
?>
