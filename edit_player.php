<!--
  Author: Adam Minaker
  Date: 4/9/2021
  Description: Edit player page, allows admins to update user data.
-->
<?php
require 'connect.php';
require 'header.php';

// Filter and sanitize super globals.
$player_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$is_admin = false;

// Check if the user is logged in and an admin.
if (isset($_SESSION['fname']) && $_SESSION['role'] === 'A') {
  $is_admin = true;
}

// Query the DB for player data.
$query = "SELECT PlayerID, Role, FName, LName, Email
          FROM players
          WHERE PlayerID = :PlayerID";
$statement = $db->prepare($query);
$statement->bindvalue(':PlayerID', $player_id);
$statement->execute();
$player = $statement->fetch();

if ($player['Role'] === 'U') {
  $current_role = 'User';
} elseif ($player['Role'] === 'A') {
  $current_role = 'Admin';
}
?>
<main>
  <?php if ($is_admin) : ?>
    <div class="text-center">
      <h3 class="mt-3 mb-4">Edit Player (ID: <?= $player['PlayerID'] ?>)</h3>
      <form action="process_player.php" method="post">
        <div class="mb-3">
          <select class="form-select" id="role" name="role" required>
            <option selected value="<?=$player['Role']?>"><?=$current_role?></option>
            <?php if ($current_role === 'Admin'): ?>
            <option value="U">User</option>
            <?php elseif ($current_role === 'User'): ?>
            <option value="A">Admin</option>
            <?php endif ?>
          </select>
        </div>
        <input type="hidden" name="player_id" value="<?= $player['PlayerID'] ?>" />
        <input class="form-control mb-3" name="fname" id="fname" placeholder="First Name" value="<?= $player['FName'] ?>" />
        <input class="form-control mb-3" name="lname" id="lname" placeholder="Last Name" value="<?= $player['LName'] ?>" />
        <input class="form-control mb-3" name="email" id="email" placeholder="Email" value="<?= $player['Email'] ?>" />
        <input class="btn btn-danger my-2" type="submit" name="command" value="Update Player" />
      </form>
    </div>
  <?php elseif (!$is_admin) : ?>
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Only admins can edit players.</h1>
        </div>
      </div>
    </section>
  <?php endif ?>
</main>
<?php require 'footer.php'; ?>