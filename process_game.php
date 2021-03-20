<!--
  Author: Adam Minaker
  Date: 3/16/2021
  Description: Handles game post requests sent to the web server.
-->
<?php
  require 'connect.php';

  // Sanitize post superglobals.
  $location_id = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_NUMBER_INT);
  $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $hourly_duration = "$duration . :00:00";

  $query = "INSERT INTO games (LocationID, duration, description) 
            VALUES (:location_id, :duration, :description)";
  $statement = $db->prepare($query);
  $statement->bindvalue(':location_id', $location_id);
  $statement->bindvalue(':duration', $hourly_duration);
  $statement->bindvalue(':description', $description);
  $statement->execute();

  header('Location: index.php');

  require 'header.php';
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">An error occured.</h1>
        <p class="lead text-muted">Please make sure you submit a game location and duration.</p>
        <p>
          <a href="index.php" class="btn btn-primary my-2">Go Back</a>
        </p>
      </div>
    </div>
  </section>
</main>
<?php
  require 'footer.php';
?>