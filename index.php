<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: Index page for GotNext, shows all games currently in progress.
-->
<?php
require 'connect.php';

date_default_timezone_set('America/Winnipeg');

// Query the db for all active games.
$query = "SELECT games.GameID, locations.LocationID, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
            FROM games
            JOIN locations ON locations.LocationID = games.LocationID
            WHERE CURRENT_TIMESTAMP < games.PostedAt + games.Duration
            ORDER BY games.PostedAt DESC";
$statement = $db->prepare($query);
$statement->execute();
$games = $statement->fetchAll();

require 'header.php';
?>
<main>
  <?php if (isset($_GET['login'])) : ?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="login-alert">
      <strong>Logged In Successfully!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif ?>
  <?php if (isset($_GET['logout'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" id="login-alert">
      <strong>Logged Out Successfully.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif ?>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Games</h1>
        <?php if (empty($games)) : ?>
          <p class="lead text-muted">No games happening right now</p>
        <?php else : ?>
          <p class="lead text-muted">Games happening right now</p>
        <?php endif ?>
        <p><a href="new_game.php" class="btn btn-danger my-2">New Game</a></p>
      </div>
    </div>
  </section>
  <!-- PHP cards -->
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach ($games as $game) : ?>
          <a href="show_game.php?id=<?= $game['GameID'] ?>" style="text-decoration: none; color: black;">
            <div class="col">
              <div class="card shadow-sm">
                <img src="<?= $game['Image'] ?>">
                <div class="card-body">
                  <h5 class="card-title"><?= $game['Name'] ?></h5>
                  <p class="card-text"><?= $game['Description'] ?></p>
                  <small class="text-muted">1/10 Players</small>
                  <?php
                  $game['PostedAt'];
                  $posted_at_epoch_seconds = strtotime($game['PostedAt']);
                  $duration_epoch_seconds = strtotime($game['Duration']);
                  $current_time_epoch_seconds = time();
                  $time_left_epoch_seconds = $duration_epoch_seconds - ($current_time_epoch_seconds - $posted_at_epoch_seconds);
                  $time_elapsed_seconds = $duration_epoch_seconds - $time_left_epoch_seconds;
                  $duration_array = explode(':', $game['Duration']);
                  $duration_hours = $duration_array[0];
                  $duration_minutes = $duration_array[1];
                  $duration_seconds = ($duration_hours * 3600) + ($duration_minutes * 60);
                  $time_left_ratio = ($time_elapsed_seconds / $duration_seconds) * 100;
                  ?>
                  <small class="text-muted" style="float: right;"><?= date('G:i:s', $time_left_epoch_seconds); ?> remaining</small>
                  <div class="progress mt-2">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $time_left_ratio ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</main>
<?php
require 'footer.php';
?>