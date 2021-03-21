<!--
  Author: Adam Minaker
  Date: 3/20/2021
  Description: Script for processing comments posted on games.
<?php
require 'connect.php';
require 'header.php';

$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$posted_by = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
$game_id = $_GET['id'];

$query = "INSERT INTO comments (PostedBy, GameID, Content) 
            VALUES (:PostedBy, :GameID, :Content)";
$statement = $db->prepare($query);
$statement->bindvalue(':PostedBy', $posted_by);
$statement->bindvalue(':GameID', $game_id);
$statement->bindvalue(':Content', $comment);
$statement->execute();

header("Location: show_game.php?id=$game_id");
?>