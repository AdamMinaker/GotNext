<!--
  Author: Adam Minaker
  Date: 4/1/2021
  Description: Edit game script, allows players to edit or delete game information.
-->
<?php
require 'connect.php';
require 'header.php';

// Sanitize inputs
$game_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Query the DB for game data.
$post_query = "SELECT GameID, LocationID, PostedBy, Description, Duration
               FROM games
               WHERE GameID = :game_id";
$statement = $db->prepare($post_query);
$statement->bindvalue(':game_id', $game_id, PDO::PARAM_INT);
$statement->execute();
$game = $statement->fetch();

$location_id = $game['LocationID'];
$duration = substr($game['Duration'], 1, 1);

// Query the DB for location data, excluding the currently selected location.
$query = "SELECT LocationID, Name
          FROM locations
          WHERE LocationID <> $location_id";
$statement = $db->prepare($query);
$statement->execute();
$locations = $statement->fetchAll();

// Query the DB for the current location
$query = "SELECT LocationID, Name
          FROM locations
          WHERE LocationID = $location_id";
$statement = $db->prepare($query);
$statement->execute();
$current_location = $statement->fetch();

?>
<?php if (isset($_SESSION['fname'])) : ?>
  <div class="text-center">
    <h3 class="mt-3 mb-4">Edit Game</h3>
    <form action="process_game.php?id=<?= $game['GameID'] ?>" method="post">
      <div class="mb-1">
        <select class="form-select mb-3" id="location" name="location">
          <option selected value="<?=$location_id?>"><?=$current_location['Name']?></option>
          <?php foreach ($locations as $location) : ?>
            <option value="<?= $location['LocationID'] ?>"><?= $location['Name'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <input class="form-control" type="number" name="duration" id="duration" placeholder="Game Duration (hours)" value="<?= $duration ?>" />
      <div class="mb-3">
        <label for="description"></label>
        <textarea class="form-control" style="height: 100px;" name="description" id="description" placeholder="Game Description"><?= $game['Description'] ?></textarea>
      </div>
      <input class="btn btn-danger my-2" type="submit" name="command" value="Update Game" />
    </form>
  </div>
<?php elseif (!isset($_SESSION['fname'])) : ?>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Please log in to edit a game.</h1>
        <p>
          <a href="login.php" class="btn btn-danger my-2">Login</a>
          <a href="register.php" class="btn btn-danger my-2">Register</a>
        </p>
      </div>
    </div>
  </section>
<?php endif ?>
<?php require 'footer.php'; ?>