<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: Index page for GotNext, shows all games currently in progress.
-->
<?php
require 'connect.php';

// Query the db for all active games.
$query = "SELECT games.GameID, locations.LocationID, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
            FROM games
            JOIN locations ON locations.LocationID = games.LocationID
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
      <strong>Logged out.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif ?>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Games</h1>
        <p class="lead text-muted">Games happening right now</p>
        <p><a href="new_game.php" class="btn btn-danger my-2">New Game</a></p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        <!-- PHP card -->
        <?php foreach ($games as $game) : ?>
          <a href="show_game.php?id=<?= $game['GameID'] ?>" style="text-decoration: none; color: black;">
            <div class="col">
              <div class="card shadow-sm">
                <img src="<?= $game['Image'] ?>">
                <div class="card-body">
                  <h5 class="card-title"><?= $game['Name'] ?></h5>
                  <p class="card-text"><?= $game['Description'] ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">10/10 Players</small>
                    <progress value="0.85"></progress>
                    <small class=" text-muted">168 mins remaining</small>
                  </div>
                </div>
              </div>
            </div>
          </a>
        <?php endforeach ?>

        <!-- Template card 
        <div class="col">
          <div class="card shadow-sm">
            <img width ="100%" height="225" src="image/court.jpg">
            <div class="card-body">
              <p class="card-text">Warren Park</p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">8/10 Players</small>
                <progress value="0.85"></progress>
                <small class="text-muted">9 mins remaining</small>
              </div>
            </div>
          </div>
        </div> 
        -->

      </div>
    </div>
  </div>
</main>
<?php
require 'footer.php';
?>