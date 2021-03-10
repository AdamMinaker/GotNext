<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: A medium for basketball players to organize games on public courts.
-->
<?php
  require 'connect.php';

  // Query the db for all active games.
  $query = "SELECT games.GameID, locations.LocationID, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
            FROM games
            JOIN locations ON locations.LocationID = games.LocationID";
  $statement = $db->prepare($query);
  $statement->execute();
  $games = $statement->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GotNext</title>
  <link href="css/bootstrap.min.css?v1.0" rel="stylesheet">
</head>
<body>
    
  <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-4">
            <p class="text-white">A medium for basketball players to organize games on public courts.</p>
          </div>
          <div class="col-sm-4 offset-md-1 py-4">
            <ul class="list-unstyled">
              <li><a href="#" class="text-white">Current Games</a></li>
              <li><a href="#" class="text-white">Court Locations</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a href="index.php" class="navbar-brand d-flex align-items-center">
          <img src="GotNext.png" alt="GotNext Logo" width="30" height="30">
          <strong style="padding-left: 10px; color: #EA5455">GotNext</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </header>

  <main>
  
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Games</h1>
          <p class="lead text-muted">Games happening right now</p>
          <p>
            <a href="#" class="btn btn-primary my-2">New Game</a>
          </p>
        </div>
      </div>
    </section>

    <div class="album py-5 bg-light">
      <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

          <!-- PHP card -->
          <?php foreach ($games as $game): ?>
            <div class="col">
              <div class="card shadow-sm">
                <img width ="100%" height="225" src="<?=$game['Image']?>">
                <div class="card-body">
                  <h5 class="card-title"><?=$game['Name']?></h5>
                  <p class="card-text"><?=$game['Description']?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">8/10 Players</small>
                    <progress value="0.85"></progress>
                    <small class="text-muted">9 mins remaining</small>
                  </div>
                </div>
              </div>
            </div>
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

  <footer class="text-muted py-5">
    <div class="container">
      <p class="mb-0">Made with &#10084; by Adam at <a href="https://www.adamminaker.com">adamminaker.com</a></p>
    </div>
  </footer>

  <script src="js/bootstrap.bundle.min.js?v1.0"></script>      
</body>
</html>
