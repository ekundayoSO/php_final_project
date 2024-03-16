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
                <li><a href="booksite.php?genre=adventure">Adventure</a></li>
                <li><a href="booksite.php?genre=classic">Classic Literature</a></li>
                <li><a href="booksite.php?genre=coming-of-age">Coming-of-age</a></li>
                <li><a href="booksite.php?genre=fantasy">Fantasy</a></li>
                <li><a href="booksite.php?genre=historical">Historical Fiction</a></li>
                <li><a href="booksite.php?genre=horror">Horror</a></li>
                <li><a href="booksite.php?genre=mystery">Mystery</a></li>
                <li><a href="booksite.php?genre=romance">Romance</a></li>
                <li><a href="booksite.php?genre=scifi">Science Fiction</a></li>
            </ul>
        </nav>
        <main>
            <?php

            // Here you should display the books of the given genre (GET parameter "genre"). Check the links above for parameter values.
            // If the parameter is not set, display all books.
            
            // Use the HTML template below and a loop (+ conditional if the genre was given) to go through the books in file  
            
            // You also need to check the cookies to figure out if the book is favorite or not and display correct symbol.
            // If the book is in the favorite list, add the class "fa-star" to the a tag with "bookmark" class.
            // If not, add the class "fa-star-o". These are Font Awesome classes that add a filled star and a star outline respectively.
            // Also, make sure to set the id parameter for each book, so the setfavorite.php page gets the information which book to favorite/unfavorite.
            
            $json = file_get_contents("books.json");
            $books = json_decode($json, true);

            if ($books !== null) { 
                if (isset($_GET['genre'])) {
                    $genre = $_GET['genre'];
                    $filteredBooks = array_filter($books, function ($book) use ($genre) {
                        return $book['genre'] == $genre;
                    });
                } else {
                    $filteredBooks = $books;
                }

                foreach ($filteredBooks as $book) {
                    $isFavorite = isset($_COOKIE['favorite_books']) && in_array($book['id'], explode(',', $_COOKIE['favorite_books']));
                    $starClass = $isFavorite ? 'fa-star' : 'fa-star-o';
                    ?>
                    <section class="book">
                        <a class="bookmark fa <?php echo $starClass; ?>"
                            href="setfavorite.php?id=<?php echo $book['id']; ?>"></a>
                        <h3>
                            <?php echo htmlspecialchars($book['title']); ?>
                        </h3>
                        <p class="publishing-info">
                            <span class="author">
                                <?php echo htmlspecialchars($book['author']); ?>
                            </span>,
                            <span class="year">
                                <?php echo $book['publishing_year']; ?>
                            </span>
                        </p>
                        <p class="description">
                            <?php echo htmlspecialchars($book['description']); ?>
                        </p>
                    </section>
                <?php
                }
            } else {
                echo "<p>Error decoding JSON.</p>";
            }
            ?>
        </main>
    </div>
    <script>
        <?php foreach ($filteredBooks as $book): ?>
            <?php
            $favorites = isset($_COOKIE['favorites']) ? explode(",", $_COOKIE['favorites']) : [];
            $is_favorite = in_array($book['id'], $favorites);
            ?>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.bookmark[data-id="<?php echo $book['id']; ?>"]').forEach(icon => {
                    icon.classList.toggle('fa-star', <?php echo $is_favorite ? 'true' : 'false'; ?>);
                    icon.classList.toggle('fa-star-o', <?php echo $is_favorite ? 'false' : 'true'; ?>);

                    icon.addEventListener('click', async event => {
                        const response = await fetch(`setfavorite.php?id=<?php echo $book['id']; ?>`);
                        // Assuming `setfavorite.php` returns JSON with `is_favorite` property
                        const data = await response.json();
                        icon.classList.toggle('fa-star', data.is_favorite);
                        icon.classList.toggle('fa-star-o', !data.is_favorite);
                    });
                });
            });
        <?php endforeach; ?>
    </script>
</body>

</html>
