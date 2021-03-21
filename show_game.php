<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Show game script, allows players to view and comment on current games.
-->
<?php
require 'connect.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// Query DB for game data.
$post_query = "SELECT games.GameID, games.LocationID, games.Description, games.Duration, games.PostedAt, locations.Name, locations.Image
               FROM games
               JOIN locations ON locations.LocationID = games.LocationID
               WHERE GameID = :id";
$statement = $db->prepare($post_query);
$statement->bindvalue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$game = $statement->fetch();

// Query DB for game comments.
$comment_query = "SELECT PostedBy, Content, PostedAt
                  FROM comments
                  WHERE GameID = :id
                  ORDER BY PostedAt DESC";
$statement = $db->prepare($comment_query);
$statement->bindvalue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$comments = $statement->fetchAll();

require 'header.php';
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light"><?= $game['Name'] ?></h1>
      </div>
    </div>
    <img class="img shadow-lg" src="<?= $game['Image'] ?>">
    <p class="lead mt-5"><?= $game['Description'] ?></p>
  </section>

  <section class="container">
    <div class="row">
      <div class="col-sm">
        <?php if (isset($_SESSION['fname'])) : ?>
          <form class="comment" action="process_comment.php?id=<?= $game['GameID'] ?>" method="POST">
            <div class="input-group mb-3">
              <input type="text" class="form-control shadow" name="comment" placeholder="Message" aria-label="Message" aria-describedby="button-addon2">
              <button class="btn btn-danger" for="comment" type="submit" id="button-addon2">Post</button>
            </div>
          </form>
        <?php else : ?>
          <div class="input-group mb-3">
            <input type="text" class="form-control shadow" name="comment" placeholder="Please login to chat" aria-label="Comment" aria-describedby="button-addon2" disabled>
            <button class="btn btn-danger" for="comment" type="submit" id="button-addon2" disabled>Post</button>
          </div>
        <?php endif ?>
        <?php foreach ($comments as $comment) :
          $date = date_create($comment['PostedAt']);
          $formatted_date = date_format($date, 'g:i a');?>
          <div class="mt-3 shadow" id="comment">
            <p><span style="float: right;"><?= $formatted_date ?></span> <?= $comment['PostedBy'] ?>:</p>
            <p><?= $comment['Content'] ?></p>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php' ?>