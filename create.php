<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: Create game page, allows players to post a new game.
-->
<?php
  require 'header.php';
?>
<main>
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>New Game</legend>
      <p>
        <label for="location">Location</label>
        <select id="location" name="location">
          <option>Test Option</option>
          <option>Warren Park</option>
        </select>
      </p>
      <p>
        <label for="duration">Duration</label>
        <input type="time" name="duration" id="duration" />
      </p>
      <p>
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
      </p>
      <p>
        <input type="submit" name="command" value="Create" />
      </p>
    </fieldset>
  </form>
</main>
<?php
  require 'footer.php';
?>