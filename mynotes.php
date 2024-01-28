<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Notes</title>

    <style>
        /* Global styles */
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Container styles */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Note styles */
        .note {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            position: relative;
        }

        .note-title {
            font-size: 18px;
            margin: 0;
        }

        .note-content {
            font-size: 14px;
            margin-top: 10px;
        }

        .delete-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        session_start();

        // Check if the user is logged in
        if (!isset($_SESSION['username'])) {
            // If not logged in, redirect to the login page
            header("Location: index.php");
            exit();
        }

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

        // Fetch user details from the database
        $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($query);

        // Check if the query was successful
        if ($result->num_rows > 0) {
            // Fetch the user data
            $row = $result->fetch_assoc();

            // Display the user details
            echo "<h2>Welcome, " . $row['name'] . "</h2>";
            

            // Check if the form is submitted to add a new note
            if (isset($_POST['title']) && isset($_POST['content'])) {
                // Get the submitted note title and content
                $noteTitle = $_POST['title'];
                $noteContent = $_POST['content'];

                // Prepare and execute the SQL query to insert the new note into the database
                $stmt = $conn->prepare("INSERT INTO notes (username, title, content) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $noteTitle, $noteContent);
                $stmt->execute();
                $stmt->close();
            }

            // Check if the delete button is clicked for a note
            if (isset($_POST['delete_note'])) {
                // Get the note ID to be deleted
                $noteId = $_POST['note_id'];

                // Prepare and execute the SQL query to delete the note from the database
                $stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
                $stmt->bind_param("i", $noteId);
                $stmt->execute();
                $stmt->close();
            }

            // Fetch the user's notes from the database
            $query = "SELECT * FROM notes WHERE username = '$username'";
            $result = $conn->query($query);

            // Check if the user has any notes
            if ($result->num_rows > 0) {
                // Display each note
                while ($noteRow = $result->fetch_assoc()) {
                    echo "<div class='note'>";
                    echo "<h3 class='note-title'>" . $noteRow['title'] . "</h3>";
                    echo "<p class='note-content'>" . $noteRow['content'] . "</p>";

                    // Add the delete button
                    echo "<form action='mynotes.php' method='POST'>";
                    echo "<input type='hidden' name='note_id' value='" . $noteRow['id'] . "'>";
                    echo "<button type='submit' name='delete_note' class='delete-button'>Delete</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                echo "<p>No notes found.</p>";
            }
        } else {
            // Handle the case if the user data is not found
            echo "<p>User not found.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>

        <!-- Add a form to add a new note -->
        <h3>Add a New Note:</h3>
        <form action="mynotes.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>

            <input type="submit" value="Add Note">
        </form>
    </div>
</body>

</html>
