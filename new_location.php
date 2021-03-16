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
  <form method="post" enctype="multipart/form-data" action="process_location.php">
    <fieldset>
      <legend>New Court Location</legend>
      <p>
        <label for="name">Location Name</label>
        <input name="name" id="name" />
      </p>
      <p>
        <label for="file">Court Image</label>
        <input type="file" name="file" id="image" />
      <p>Please upload court images in landscape mode.</p>
      </p>
      <p>
        <input type="submit" name="submit" value="Add Location" />
      </p>
    </fieldset>
  </form>
</main>
<?php
require 'footer.php';
?>