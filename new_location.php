<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: New location page, allows players to post a new court location.
-->
<?php
require 'connect.php';

require 'header.php';
?>
<main>
  <div class="text-center">
    <h3 class="mt-3 mb-4">New Court Location</h3>
    <?php if (isset($_GET['new-game'])) : ?>
      <form method="post" enctype="multipart/form-data" action="process_location.php?new-game">
    <?php elseif (isset($_GET['locations'])) : ?>
      <form method="post" enctype="multipart/form-data" action="process_location.php?locations">
    <?php endif ?>
    <input class="form-control mb-3" name="name" id="name" placeholder="Location Name" required />
    <label class="form-label" for="file">Court Image (Optional)</label>
    <input class="form-control mb-3" type="file" name="file" id="image" />
    <input class="btn btn-danger my-2" type="submit" name="command" value="Add Court" />
    </form>
  </div>
</main>
<?php
require 'footer.php';
?>