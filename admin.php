<!--
  Author: Adam Minaker
  Date: 4/9/2021
  Description: Admin dashboard for editing and deleting users.
-->
<?php
require 'connect.php';
require 'header.php';

// Query the db for all registered players.
$query = "SELECT PlayerID, Role, FName, LName, Email, JoinedAt
          FROM players
          ORDER BY PlayerID DESC";
$statement = $db->prepare($query);
$statement->execute();
$players = $statement->fetchAll();
?>
<main>
  <?php if (isset($_SESSION['fname']) && $_SESSION['role'] === 'A') : ?>
    <div class="table-responsive">
      <table class="table table-danger table-striped">
        <thead>
          <tr>
            <th>PlayerID</th>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Date Joined</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($players as $player) : ?>
            <tr>
              <td><?= $player['PlayerID'] ?></td>
              <?php if ($player['Role'] === 'A') : ?>
                <td>Admin</td>
              <?php elseif ($player['Role'] === 'U') : ?>
                <td>User</td>
              <?php endif ?>
              <td><?= $player['FName'] ?></td>
              <td><?= $player['LName'] ?></td>
              <td><?= $player['Email'] ?></td>
              <td><?= date('m-d-Y', strtotime($player['JoinedAt'])) ?></td>
              <td>
                <form action="process_player.php" method="POST" id="admin">
                  <input type="hidden" name="player_id" value="<?= $player['PlayerID'] ?>" />
                  <a href="edit_player.php?id=<?= $player['PlayerID'] ?>" class="btn btn-danger btn-sm">Edit</a>
                  <input class="btn btn-danger btn-sm" name="command" type="submit" value="Delete" />
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <div id="add-player">
      <a href="register.php" class="btn btn-danger">Add Player</a>
    </div>
  <?php endif ?>
</main>
<?php require 'footer.php'; ?>