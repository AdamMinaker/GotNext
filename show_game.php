<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Show game script, allows players to view, join, and comment on current games.
-->
<?php
require 'connect.php';
require 'header.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Query the DB for game data.
$post_query = "SELECT games.GameID, games.LocationID, games.PostedBy, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
               FROM games
               JOIN locations ON locations.LocationID = games.LocationID
               WHERE GameID = :id";
$statement = $db->prepare($post_query);
$statement->bindvalue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$game = $statement->fetch();

// Query the DB for game players.
$players_query = "SELECT gameplayers.GameID, gameplayers.PlayerID, players.FName, players.LName
                  FROM gameplayers
                  JOIN players ON players.PlayerID = gameplayers.PlayerID
                  WHERE GameID = :id";
$statement = $db->prepare($players_query);
$statement->bindvalue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$players = $statement->fetchAll();

// Determine if the player is in the game.
$in_game = false;

if (isset($_SESSION['fname'])) {
  foreach ($players as $player) {
    if ($_SESSION['id'] === $player['PlayerID']) {
      $in_game = true;
    }
  }
}

// Query the DB for game comments.
$comment_query = "SELECT PostedBy, PlayerID, Content, PostedAt, CommentID
                  FROM comments
                  WHERE GameID = :id
                  ORDER BY PostedAt";
$statement = $db->prepare($comment_query);
$statement->bindvalue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll();
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light"><?= $game['Name'] ?></h1>
      </div>
    </div>
    <?php if (!empty($game['Image'])): ?>
      <img class="img shadow-lg" src="<?= $game['Image'] ?>">
    <?php endif ?>
    <p class="lead mt-5"><?= $game['Description'] ?></p>
    <?php if (isset($_SESSION['fname'])) :
      if ($_SESSION['id'] === $game['PostedBy'] || $_SESSION['role'] === 'A') : ?>
        <form action="process_game.php?id=<?= $game['GameID'] ?>" method="POST">
          <a class="btn btn-danger btn-sm" href="edit_game.php?id=<?= $game['GameID'] ?>">Edit</a>
          <input class="btn btn-danger btn-sm" name="command" type="submit" value="Delete" />
        </form>
      <?php endif ?>
      <?php if (!$in_game): ?>
        <form class="mt-4" action="process_game.php?id=<?= $id ?>" method="POST">
          <input class="btn btn-danger btn-lg" name="command" type="submit" value="Join Game" />
        </form>
      <?php endif ?>
    <?php endif ?>
    <div id="players">
      <ul class="list-group mt-4">
        <?php if (!empty($players)): ?>
          <li class="list-group-item list-group-item-danger">Players</li>
        <?php endif ?>
        <?php foreach ($players as $player) : ?>
          <li class="list-group-item"><?= $player['FName'] . ' ' . $player['LName'] ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  </section>

  <section class="container">
    <div class="row">
      <div class="col-sm">
        <?php if (isset($_SESSION['fname'])) : ?>
          <form class="comment" action="process_comment.php?id=<?= $game['GameID'] ?>" method="POST">
            <div class="input-group mb-3">
              <input type="text" class="form-control shadow" name="comment" placeholder="Message" aria-label="Message" aria-describedby="button-addon2" autocomplete="off">
              <input class="btn btn-danger" for="comment" type="submit" id="button-addon2" name="command" value="Post" />
            </div>
          <?php else : ?>
            <div class="input-group mb-3">
              <input type="text" class="form-control shadow" name="comment" placeholder="Please login to chat" aria-label="Comment" aria-describedby="button-addon2" disabled>
              <button class="btn btn-danger" for="comment" type="submit" id="button-addon2" disabled>Post</button>
            </div>
          <?php endif ?>
          <?php foreach ($comments as $comment) :
            $date = date_create($comment['PostedAt']);
            $formatted_date = date_format($date, 'g:i a'); ?>
            <div class="mt-3 shadow" id="comment">
              <p><span style="float: right;"><?= $formatted_date ?></span> <?= $comment['PostedBy'] ?>:</p>
              <p><?= $comment['Content'] ?></p>
              <?php if (isset($_SESSION['fname'])) :
                if ($_SESSION['id'] === $comment['PlayerID'] || $_SESSION['role'] === 'A') : ?>
                  <input class="btn btn-danger my-2 btn-sm" type="submit" name="<?= $comment['CommentID'] ?>" value="Delete" />
              <?php endif;
              endif; ?>
            </div>
          <?php endforeach ?>
          </form>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php' ?>