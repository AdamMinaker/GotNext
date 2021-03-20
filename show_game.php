<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Show game script, allows players to view and comment on current games.
-->
<?php
require 'connect.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$post_query = "SELECT games.GameID, games.LocationID, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
               FROM games
               JOIN locations ON locations.LocationID = games.LocationID
               WHERE GameID = :id";
$statement = $db->prepare($post_query);
$statement->bindvalue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$game = $statement->fetch();

require 'header.php';
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light"><?= $game['Name'] ?></h1>
        <p class="lead text-muted"><?= $game['Description'] ?></p>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php' ?>