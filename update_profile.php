<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Get the form data
$name = $_POST['name'];
$bio = $_POST['bio'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "institute_access";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_FILES['profile_photo']['name'] !== '') {
    // Retrieve the new profile photo details
    $file = $_FILES['profile_photo'];
    $filename = $file['name'];
    $tmpFilePath = $file['tmp_name'];

    // Specify the directory to store the uploaded photo
    $uploadDir = 'uploads/';

    // Generate a unique filename for the uploaded photo
    $newPhotoFilename = uniqid() . '_' . $filename;

    // Move the uploaded photo to the upload directory
    $newFilePath = $uploadDir . $newPhotoFilename;
    move_uploaded_file($tmpFilePath, $newFilePath);
}
// Prepare and execute the update query
$sql = "UPDATE users SET name='$name', bio='$bio' WHERE username='{$_SESSION['username']}'";

if (isset($newPhotoFilename)) {
    // Prepare the SQL statement to update the user's profile photo filename
    $sqlPhoto = "UPDATE users SET profile_photo = '$newPhotoFilename' WHERE username = '{$_SESSION['username']}'";

    // Execute the SQL statement
    if ($conn->query($sqlPhoto) === true) {
        echo "Profile photo updated successfully.";
    } else {
        echo "Failed to update profile photo: " . $conn->error;
    }
}




if ($conn->query($sql) === TRUE) {
    // Update successful, redirect to the profile page
    header("Location: studenthome.php");
    exit;
} else {
    // Error in update, handle accordingly
    echo "Error updating profile: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
