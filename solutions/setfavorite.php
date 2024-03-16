<?php

// You will receive a GET parameter "id", which contains the book id.
// Check the cookie (with the name of your choice). It's recommended to save the favorite'd book ids as an array turned into string. E.g.
// $favorites = array(1, 4, 6);
// $favorites_string = implode(",", $favorites); // "1,4,6"
// setcookie("favorites", $favorites_string, time()+86400*30);
// $favorites = explode(",", $_COOKIE["favorites"]);

// If the cookie's not set or this id is not part of the cookie, add this id and send the cookie to the user.
// If it's part of the cookie, remove it and send the new cookie to the user.
// By far the easiest way to remove a specific item (not index) from array is to use array_diff function, e.g.
// $favorites = array_diff($favorites, array($id));
// This takes the items in the first array ($favorites) that are not in the second array (containing only the book id), and puts the result back to $favorites

// Redirect back to booksite.php. If you want to redirect to the exact page user came from, that's header("Location:" . $_SERVER["HTTP_REFERER"]);
// And no, that's not a typo. It is HTTP_REFERER.

$id = $_GET['id'] ?? null;
$favorites = isset($_COOKIE['favorite_books']) ? explode(",", $_COOKIE['favorite_books']) : [];

if (($key = array_search($id, $favorites)) !== false) {
    unset($favorites[$key]);
    $isFavorite = false;
} else {
    $favorites[] = $id;
    $isFavorite = true;
}

$favorites_string = implode(",", $favorites);

$oneDay = 60 * 60 * 24; // 86400s or 1 day
$oneMonth = 30; // 30 days
$expirationDay = time() + ($oneDay * $oneMonth);

setcookie("favorite_books", $favorites_string, $expirationDay,"/");

// Respond with JSON including the updated favorite status
echo json_encode(array('is_favorite' => $isFavorite));

if (isset ($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit;
}