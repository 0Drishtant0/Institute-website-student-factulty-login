<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
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

// Fetch the logged-in user's tasks from the database
$username = $_SESSION['username'];
$query = "SELECT * FROM todo_list WHERE username = '$username'";
$result = $conn->query($query);

// Create an array to store the tasks
$tasks = array();

// Check if there are any tasks for the user
if ($result->num_rows > 0) {
    // Fetch the tasks and store them in the array
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row['task'];
    }
}

// Add a new task to the database
if (isset($_POST['task'])) {
    $task = $_POST['task'];

    // Insert the task into the database
    $insertQuery = "INSERT INTO todo_list (username, task) VALUES ('$username', '$task')";
    $conn->query($insertQuery);

    // Redirect to the current page to prevent form resubmission
    header("Location: todolist.php");
    exit();
}

// Delete a task from the database
if (isset($_GET['delete'])) {
    $task = $_GET['delete'];

    // Delete the task from the database
    $deleteQuery = "DELETE FROM todo_list WHERE username = '$username' AND task = '$task'";
    $conn->query($deleteQuery);

    // Redirect to the current page to prevent form resubmission
    header("Location: todolist.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <style>
        
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 500px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 80%;
            padding: 10px;
            font-size: 18px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #58a954;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        ul {
            padding-left: 0;
            list-style-type: none;
        }

        .todo-item {
            margin-bottom: 10px;
            font-size: 18px;
            position: relative;
            cursor: pointer;
        }

        .todo-item label {
            text-decoration: none;
            color: #000;
        }

        .todo-item.checked label {
            text-decoration: line-through;
            color: #999;
        }

        .todo-item::before {
            content: "";
            position: absolute;
            left: -25px;
            top: 8px;
            width: 18px;
            height: 18px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .todo-item::after {
            content: "";
            position: absolute;
            left: -20px;
            top: 12px;
            width: 10px;
            height: 6px;
            border-left: 2px solid #58a954;
            border-bottom: 2px solid #58a954;
            transform: rotate(-45deg);
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .todo-item.checked::before {
            background-color: #58a954;
            border-color: #58a954;
        }

        .todo-item.checked::after {
            opacity: 1;
        }
    </style>

    </style>
</head>

<body>
    <!-- HTML content -->

    <h1>Todo List</h1>

    <!-- Display the tasks -->
    <ul>
        <?php foreach ($tasks as $task) : ?>
            <li>
                <?php echo $task; ?>
                <a href="todolist.php?delete=<?php echo urlencode($task); ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Add new task form -->
    <form method="POST" action="todolist.php" id="todo-form">
        <input type="text" name="task" required>
        <button type="submit">Add Task</button>
    </form>

    <!-- JavaScript code -->

    <script>
        <script>
        // Get the form and input elements
        const form = document.getElementById('todo-form');
        const input = document.getElementById('todo-input');
        // Get the list element
        const list = document.getElementById('todo-list');

        // Function to create a new todo item
        function createTodoItem(text) {
            // Create list item element
            const listItem = document.createElement('li');
            listItem.className = 'todo-item';

            // Create label element
            const label = document.createElement('label');
            label.textContent = text;

            // Append label to list item
            listItem.appendChild(label);

            // Add event listener to list item to handle completed tasks
            listItem.addEventListener('click', function() {
                listItem.classList.toggle('checked');
            });

            return listItem;
        }

        // Function to add a new task
        function addTask(event) {
            event.preventDefault();
            const text = input.value.trim();
            if (text !== '') {
                const listItem = createTodoItem(text);
                list.appendChild(listItem);
                input.value = '';
            }
        }

        // Add event listener to form submit event
        form.addEventListener('submit', addTask);
    </script>

    </script>
</body>

</html>
