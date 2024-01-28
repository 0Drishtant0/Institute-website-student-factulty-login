
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- aos animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- loading bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="./css/flash.css">
    <title></title>
</head>
<style>
    .user-details {
    text-align: center;
    margin-bottom: 20px;
}

.user-details h3 {
    font-size: 18px;
    margin: 5px 0;
}

.user-details p {
    font-size: 14px;
    margin: 5px 0;
}

.link-list {
    list-style: none;
    padding: 0;
    margin-bottom: 20px;
}

.link-list li {
    margin-bottom: 10px;
}

.link-list li a {
    display: block;
    text-decoration: none;
    padding: 10px;
    background-color: #f2f2f2;
    border-radius: 5px;
    color: #333;
}

.link-list li a:hover {
    background-color: #e0e0e0;
}

    </style>
<body>
    <!--  carousel -->
    <section id="carouselExampleControls" class="carousel slide carousel_section" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="carousel-image" src="hq/image1.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="hq/image1.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="hq/image1.jpg">
            </div>
            <div class="carousel-item">
                <img class="carousel-image" src="hq/image1.jpg">
            </div>
        </div>
    </section>

    <!-- main section -->
    <section id="auth_section">

        <div class="logo">
            <img class="bluebirdlogo" src="IIITN-logo-90x90.png" alt="logo">
            <p>STUDENT MODE</p>
        </div>
        <div class="user-details">
    <?php
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['username'])) {
        // If not logged in, redirect to the login page
        header("Location: index.html");
        exit();
    }
    if (isset($_GET['logout'])) {
        // End the current session
        session_destroy();
    
        // Redirect to the index page
        header("Location: index.html");
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

        // Display the profile photo, name, and bio
        echo "<div class='profile-photo'>";
       

    // ...

    // Display the profile photo or default photo if no photo exists
    if ($row['profile_photo']) {
        echo "<img src='uploads/" . $row['profile_photo'] . "' alt='Profile Photo'>";
    } else {
        echo "<img src='uploads/defphoto.jpg' alt='Default Profile Photo'>";
    }


        echo "</div>";
        echo "<div class='user-info'>";
        echo "<h3>Welcome, " . $row['name'] . "</h3>";
        echo "<p>" . $row['bio'] . "</p>";
        echo "</div>";
    }
    ?>
</div>

<ul class="link-list">
    <li><a href="edit_profile.html">Edit Profile</a></li>
    <li><a href="todolist.php">MY Todo list</a></li>
    <li><a href="mynotes.php">MY notes</a></li>
    <li><a href="studenthome.php?logout=true">Logout</a></li>
</ul>


    </section>
</body>


<script src="./js/index.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- aos animation-->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</html>

