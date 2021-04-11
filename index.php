<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: Index page for GotNext, shows all games currently in progress.
-->
<?php
require 'connect.php';

date_default_timezone_set('America/Winnipeg');

// Sanitize get superglobal.
$sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Determine sorting method.
$order_by = 'games.PostedAt DESC';

if (isset($_GET['sort'])) {
  if ($sort === 'duration') {
    $order_by = 'games.Duration DESC';
  } elseif ($sort === 'location-name') {
    $order_by = 'locations.Name';
  }
}

// Query the db for all active games.
$query = "SELECT games.GameID, locations.LocationID, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
          FROM games
          JOIN locations ON locations.LocationID = games.LocationID
          WHERE CURRENT_TIMESTAMP < games.PostedAt + games.Duration
          ORDER BY $order_by";
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
        <?php if (!empty($games)) : ?>
          <p class="mt-5 text-muted">Sort Games By:</p>
          <div class="btn-group">
            <?php if (empty($sort)) : ?>
              <a href="index.php" class="btn btn-outline-danger btn-sm active">Start Time</a>
              <a href="index.php?sort=duration" class="btn btn-outline-danger btn-sm">Duration</a>
              <a href="index.php?sort=location-name" class="btn btn-outline-danger btn-sm">Location Name</a>
            <?php elseif ($sort === 'duration') : ?>
              <a href="index.php" class="btn btn-outline-danger btn-sm">Start Time</a>
              <a href="index.php?sort=duration" class="btn btn-outline-danger btn-sm active">Duration</a>
              <a href="index.php?sort=location-name" class="btn btn-outline-danger btn-sm">Location Name</a>
            <?php elseif ($sort === 'location-name') : ?>
              <a href="index.php" class="btn btn-outline-danger btn-sm">Start Time</a>
              <a href="index.php?sort=duration" class="btn btn-outline-danger btn-sm">Duration</a>
              <a href="index.php?sort=location-name" class="btn btn-outline-danger btn-sm active">Location Name</a>
            <?php endif ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </section>
  <!-- Game Cards -->
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach ($games as $game) : ?>
          <a href="show_game.php?id=<?= $game['GameID'] ?>" style="text-decoration: none; color: black;">
            <div class="col">
              <div class="card shadow-sm">
                <?php if (!empty($game['Image'])) : ?>
                  <img src="<?= $game['Image'] ?>" alt="<?= $game['Name'] ?>">
                <?php endif ?>
                <div class="card-body">
                  <h5 class="card-title"><?= $game['Name'] ?></h5>
                  <p class="card-text"><?= $game['Description'] ?></p>
                  <?php
                  $game_id = $game['GameID'];
                  $query = "SELECT COUNT(PlayerID)
                    FROM gameplayers
                    WHERE GameID = $game_id";
                  $statement = $db->prepare($query);
                  $statement->execute();
                  $players = $statement->fetch();
                  $player_count = $players['COUNT(PlayerID)'];
                  $time_left_epoch_seconds = strtotime($game['Duration']) - (time() - strtotime($game['PostedAt']));
                  $time_elapsed_seconds = strtotime($game['Duration']) - $time_left_epoch_seconds;
                  $duration_array = explode(':', $game['Duration']);
                  $duration_hours = $duration_array[0];
                  $duration_minutes = $duration_array[1];
                  $duration_seconds = ($duration_hours * 3600) + ($duration_minutes * 60);
                  $time_left_ratio = ($time_elapsed_seconds / $duration_seconds) * 100;
                  ?>
                  <small class="text-muted"><?= $player_count ?>/10 Players</small>
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