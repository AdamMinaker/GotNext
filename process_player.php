<!--
  Author: Adam Minaker
  Date: 4/9/2021
  Description: Process player script, allows admins to edit and delete users.
-->
<?php
require 'connect.php';
require 'header.php';

// Filter and sanitize super globals.
$player_id = filter_input(INPUT_POST, 'player_id', FILTER_SANITIZE_NUMBER_INT);
$role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Check if the user is logged in and an admin.
if (isset($_SESSION['fname']) && $_SESSION['role'] === 'A') {
  if ($_POST['command'] === 'Delete') {
    $query = "DELETE FROM players
              WHERE PlayerID = :PlayerID";
    $statement = $db->prepare($query);
    $statement->bindvalue(':PlayerID', $player_id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin.php");
  }

  if ($_POST['command'] === 'Update Player') {
    $query = "UPDATE players 
              SET Role = :Role, FName = :FName, LName = :LName, Email = :Email
              WHERE PlayerID = :PlayerID";
    $statement = $db->prepare($query);
    $statement->bindvalue(':Role', $role);
    $statement->bindvalue(':FName', $fname);
    $statement->bindvalue(':LName', $lname);
    $statement->bindvalue(':Email', $email);
    $statement->bindvalue(':PlayerID', $player_id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: admin.php");
  }
}

require 'footer.php';
?>