<!--
  Author: Adam Minaker
  Date: 3/16/2021
  Description: Handles game post requests sent to the web server.
-->
<?php
  require 'connect.php';
  require 'header.php';

  // Check if the player is logged in.
  if (isset($_SESSION['fname'])) {
    // Sanitize get and post superglobals.
    $location_id = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_NUMBER_INT);
    $player_id = $_SESSION['id'];
    $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $game_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $hourly_duration = "$duration:00:00";

    // Insert new game into the DB.
    if ($_POST['command'] === 'Create Game') {
      if (!empty($location_id) && !empty($duration)) {
      $query = "INSERT INTO games (LocationID, PostedBy, duration, description) 
                VALUES (:location_id, :posted_by, :duration, :description)";
      $statement = $db->prepare($query);
      $statement->bindvalue(':location_id', $location_id);
      $statement->bindvalue(':posted_by', $player_id, PDO::PARAM_INT);
      $statement->bindvalue(':duration', $hourly_duration);
      $statement->bindvalue(':description', $description);
      $statement->execute();

      // Remove the player that created the game from any other games they may have joined before.
      $query = "DELETE FROM gameplayers
                WHERE PlayerID = :player_id";
      $statement = $db->prepare($query);
      $statement->bindvalue(':player_id', $player_id);
      $statement->execute();

      header('Location: index.php');
      }
    }

    $post_query = "SELECT GameID, LocationID, PostedBy, Description, Duration, PostedAt
                  FROM games
                  WHERE GameID = :game_id";
    $statement = $db->prepare($post_query);
    $statement->bindvalue(':game_id', $game_id, PDO::PARAM_INT);
    $statement->execute();
    $game = $statement->fetch();
    
    // Check if the player posted the game or if they are an admin.
    if ($game['PostedBy'] === $_SESSION['id'] || $_SESSION['role'] === 'A') {
      // Update a game in the DB.
      if ($_POST['command'] === 'Update Game') {
        $query = "UPDATE games 
                  SET description = :description, duration = :duration, locationid = :location
                  WHERE GameID = :game_id";                
        $statement = $db->prepare($query);
        $statement->bindvalue(':description', $description);
        $statement->bindvalue(':duration', $hourly_duration);
        $statement->bindvalue(':location', $location_id);
        $statement->bindvalue(':game_id', $game_id, PDO::PARAM_INT);
        $statement->execute();

        header('Location: show_game.php?id=' . $_GET['id']);
      }
      
      // Delete a game from the DB.
      if ($_POST['command'] === 'Delete') {
        $query = "DELETE FROM games 
                  WHERE GameID = :game_id";
        $statement = $db->prepare($query);
        $statement->bindvalue(':game_id', $game_id, PDO::PARAM_INT);
        $statement->execute();

        header('Location: index.php');
      }
    }

    // Insert a game player into the DB.
    if ($_POST['command'] === 'Join Game') {
      // Remove the player from any other games they may have joined before.
      $query = "DELETE FROM gameplayers
                WHERE PlayerID = :player_id";
      $statement = $db->prepare($query);
      $statement->bindvalue(':player_id', $player_id);
      $statement->execute();

      // Add the player to their game of choice.
      $query = "INSERT INTO gameplayers (GameID, PlayerID)
                VALUES (:game_id, :player_id)";
      $statement = $db->prepare($query);
      $statement->bindvalue(':game_id', $game_id);
      $statement->bindvalue(':player_id', $player_id);
      $statement->execute();

      header('Location: show_game.php?id=' . $game_id);
    }

    // Delete a game player from the DB.
    if ($_POST['command'] === 'Leave Game') {
      $query = "DELETE FROM gameplayers
                WHERE PlayerID = :player_id";
      $statement = $db->prepare($query);
      $statement->bindvalue(':player_id', $player_id);
      $statement->execute();

      header('Location: show_game.php?id=' . $game_id);
    }
  }
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">An error occured.</h1>
        <p class="lead text-muted">Please make sure you submit a game location and duration.</p>
        <p>
          <a href="new_game.php" class="btn btn-danger my-2">Go Back</a>
        </p>
      </div>
    </div>
  </section>
</main>
<?php
  require 'footer.php';
?>