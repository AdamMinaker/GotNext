<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: New location page, allows players to post a new court location.
-->
<?php
require 'connect.php';
require 'header.php';

// Determine if the form should redirect to the locations page or the new game page.
if (isset($_GET['new-game'])) {
  $action = 'process_location.php?new-game';
} elseif (isset($_GET['locations'])) {
  $action = 'process_location.php?locations';
}
?>
<main>
  <div class="text-center">
    <h3 class="mt-3 mb-4">New Court Location</h3>
    <form method="post" enctype="multipart/form-data" action="<?= $action ?>" class="needs-validation" novalidate>
      <input class="form-control" name="name" id="name" placeholder="Location Name" required />
      <div class="invalid-feedback">
        Please provide a location name.
      </div>
      <label class="form-label mt-3" for="file">Court Image (Optional)</label>
      <input class="form-control mb-3" type="file" name="file" id="image" />
      <input class="btn btn-danger my-2" type="submit" name="command" value="Add Court" />
    </form>
  </div>
</main>
<?php require 'footer.php'; ?>