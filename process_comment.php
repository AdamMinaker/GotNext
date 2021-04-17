<!--
  Author: Adam Minaker
  Date: 3/20/2021
  Description: Script for processing comments posted on games.
<?php
require 'connect.php';
require 'header.php';

$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$posted_by = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
$player_id = $_SESSION['id'];
$game_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Query to post a comment to the DB.
if (!empty($comment) && $_POST['command'] === 'Post') {
  $query = "INSERT INTO comments (PostedBy, PlayerID, GameID, Content) 
            VALUES (:PostedBy, :PlayerID, :GameID, :Content)";
  $statement = $db->prepare($query);
  $statement->bindvalue(':PostedBy', $posted_by);
  $statement->bindvalue(':PlayerID', $player_id, PDO::PARAM_INT);
  $statement->bindvalue(':GameID', $game_id, PDO::PARAM_INT);
  $statement->bindvalue(':Content', $comment);
  $statement->execute();
}

// Query to delete a comment from the DB.
$keys = array_keys($_POST);
$comment_id = filter_var($keys[1], FILTER_SANITIZE_NUMBER_INT);

if (is_int($keys[1])) {
  $query = "DELETE FROM comments
            WHERE CommentID = :CommentID";
  $statement = $db->prepare($query);
  $statement->bindvalue(':CommentID', $comment_id);
  $statement->execute();
}

header("Location: show_game.php?id=$game_id");
?>