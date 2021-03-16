<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: New game page, allows players to post a new game.
-->
<?php
  require 'connect.php';

  $query = "SELECT LocationID, Name
            FROM locations";
  $statement = $db->prepare($query);
  $statement->execute();
  $locations = $statement->fetchAll();

  require 'header.php';
?>
<main>
  <form action="process_game.php" method="post">
    <fieldset>
      <legend>New Game</legend>
      <p>
        <label for="location">Location</label>
        <select id="location" name="location">
          <?php foreach($locations as $location): ?>
            <option value="<?=$location['LocationID']?>"><?=$location['Name']?></option>
          <?php endforeach ?>
        </select>
      </p>
      <p>
        <label for="duration">Duration</label>
        <input type="number" name="duration" id="duration" placeholder="2 hours" />
      </p>
      <p>
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
      </p>
      <p>
        <input type="submit" name="command" value="Create Game" />
      </p>
    </fieldset>
  </form>
</main>
<?php
  require 'footer.php';
?>