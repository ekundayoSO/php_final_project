<?php
// If the user is not logged in, redirect them back to login.php.

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect them back to login.php
    header("Location: login.php");
    exit(); // Stop further execution of the script
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
                <li><a href="admin.php">Admin Home</a></li>
                <li><a href="addbook.php">Add a New Book</a></li>
                <li><a href="login.php?logout">Log Out</a></li>
            </ul>
        </nav>
        <main>
            <h2>All Books</h2>
            <?php
            // This is almost identical to booksite.php (minus the genres). Make sure to print the correct id to the delete form.
            ?>
            <section class="book">
                <form class="deleteform" action="deletebook.php" method="post">
                    <input type="hidden" name="bookid" value="1">
                    <input type="submit" name="deletebook" value="Delete">
                </form>
                <h3>To Kill a Mockingbird</h3>
                <p class="publishing-info">
                    <span class="author">Harper Lee</span>,
                    <span class="year">1960</span>
                </p>
                <p class="description">
                    Harper Lee's masterpiece explores racial injustice and moral growth through the eyes of a young girl
                    in the American South.
                </p>
            </section>
        </main>
    </div>
</body>

</html>