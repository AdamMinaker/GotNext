<!--
  Author: Adam Minaker
  Date: 4/10/2021
  Description: Locations page for GotNext, shows all locations created by the player or all locations to admins.
-->
<?php
require 'connect.php';
require 'header.php';

$player_id = $_SESSION['id'];

if ($_SESSION['role'] === 'U') {
  // Query the DB for locations created by the player.
  $query = "SELECT LocationID, Name, Image
            FROM locations
            WHERE PostedBy = $player_id
            ORDER BY LocationID DESC";
  $statement = $db->prepare($query);
  $statement->execute();
  $locations = $statement->fetchAll();
}

if ($_SESSION['role'] === 'A') {
  // Query the DB for all locations.
  $query = "SELECT LocationID, Name, Image
            FROM locations
            ORDER BY LocationID DESC";
  $statement = $db->prepare($query);
  $statement->execute();
  $locations = $statement->fetchAll();
}
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <?php if ($_SESSION['role'] === 'U') : ?>
          <h1 class="fw-light">My Locations</h1>
        <?php elseif ($_SESSION['role'] === 'A') : ?>
          <h1 class="fw-light">All Locations</h1>
        <?php endif ?>
        <p><a href="new_location.php?locations" class="btn btn-danger my-2">Add Location</a></p>
      </div>
    </div>
  </section>
  <!-- Location Cards -->
  <div class="album py-5 bg-light">
    <div class="container ">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php foreach ($locations as $location) : ?>
          <div class="col">
            <div class="card shadow-sm">
              <?php if (!empty($location['Image'])) : ?>
                <img src="<?= $location['Image'] ?>">
              <?php endif ?>
              <div class="card-body">
                <form id="edit-location" action="process_location.php" method="POST">
                  <input class="form-control" name="name" value="<?= $location['Name'] ?>" required />
                  <?php if (!empty($location['Image'])) : ?>
                    <label class="form-label">Remove Image</label>
                    <input class="mt-3" type="checkbox" id="remove_image" name="remove_image" value="true">
                  <?php endif ?>
                  <input type="hidden" name="location_id" value="<?= $location['LocationID'] ?>" />
                  <div class="d-flex mt-1">
                    <input class="btn btn-danger btn-sm mt-1" type="submit" name="command" value="Save Changes" />
                    <input class="btn btn-danger btn-sm mt-1 ms-1" type="submit" name="command" value="Delete" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</main>
<?php require 'footer.php'; ?>