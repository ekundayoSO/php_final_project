<?php

$message = '';
// Check if the GET parameter "logout" is set. If so, log the user out.

// Check if the user is already logged in. If so, redirect to admin.php.

// Check if the form has been sent. If so, check the username and password and if correct, log the user in and redirect to admin.php.

// If not correct, show the error message near the form.


if (isset($_GET["logout"])) {
    // destroy the session
    session_start();
    session_unset();
    session_destroy();

    $message = "Logout successful.";

}

if (isset($_POST["username"]) && isset($_POST["password"])) {
   
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'password') {
        session_start();
        $_SESSION["username"] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        header('Location: admin.php');
        exit();

    } else {
        // else set $error_msg to "Wrong username or password."
        $message = "Wrong username and password.";
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="booksite.css">
</head>

<body>
    <div id="container">
        <header>
            <h1>Your Favorite Books</h1>
        </header>
        <nav id="main-navi">
            <ul>
                <li><a href="booksite.php">Home</a></li>
                <li><a href="booksite.php?category=adventure">Adventure</a></li>
                <li><a href="booksite.php?category=classic">Classic Literature</a></li>
                <li><a href="booksite.php?category=coming-of-age">Coming-of-age</a></li>
                <li><a href="booksite.php?category=fantasy">Fantasy</a></li>
                <li><a href="booksite.php?category=historical">Historical Fiction</a></li>
                <li><a href="booksite.php?category=horror">Horror</a></li>
                <li><a href="booksite.php?category=mystery">Mystery</a></li>
                <li><a href="booksite.php?category=romance">Romance</a></li>
                <li><a href="booksite.php?category=scifi">Science Fiction</a></li>
            </ul>
        </nav>
        <main>
            <form action="login.php" method="post">
                <p>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username">
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </p>
                <p><input type="submit" name="login" value="Log in"></p>
                <p><?php print $message; ?>
                </p>
            </form>
        </main>
    </div>
</body>

</html>