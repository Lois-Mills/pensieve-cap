<?php
include_once("../classes/book_class.php");
function uploadBookController($user_id, $title, $author, $file_path) {
    $book = new Book();
    return $book->uploadBook($user_id, $title, $author, $file_path);
}

function getAllBooksController() {
    $book = new Book();
    return $book->getAllBooks();
}

function getUserBooksController($user_id) {
    $book = new Book();
    return $book->getUserBooks($user_id);
}

// function updateReadingProgress($user_id) {
//     $book = new Book();
    
//     // Check if user progress exists; create if not
//     $progress = $book->getUserProgress($user_id);
//     if (!$progress) {
//         $book->createUserProgress($user_id);
//         $progress = ["xp_points" => 0, "reading_streak" => 0, "last_read_date" => null];
//     }

//     $xp = $progress["xp_points"] + 10; // Add 10 XP per session
//     $streak = $progress["reading_streak"];
//     $last_read = $progress["last_read_date"];
//     $today = date('Y-m-d');

//     // Update streak if reading on consecutive days
//     if ($last_read == date('Y-m-d', strtotime("-1 day"))) {
//         $streak++;
//     } else {
//         $streak = 1; // Reset streak if a day is skipped
//     }

//     // Update progress in DB
//     return $book->updateUserProgress($user_id, $xp, $streak, $today);
// }
