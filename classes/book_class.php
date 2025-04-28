<?php
require_once("../settings/db_class.php");

class Book extends db_connection {
    // Function to upload book
    public function uploadBook($user_id, $title, $author, $file_path) {
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $author = mysqli_real_escape_string($this->db_conn(), $author);
        $file_path = mysqli_real_escape_string($this->db_conn(), $file_path);

        $sql = "INSERT INTO books (user_id, title, author, file_path, uploaded_at) VALUES ('$user_id', '$title', '$author', '$file_path', NOW())";
        return $this->db_query($sql);
    }

    // Function to fetch all books
    public function getAllBooks() {
        $sql = "SELECT * FROM books";
        return $this->db_fetch_all($sql);
    }

    // Function to fetch books by user
    public function getUserBooks($user_id) {
        $sql = "SELECT * FROM books WHERE user_id = '$user_id'";
        return $this->db_fetch_all($sql);
    }

}

