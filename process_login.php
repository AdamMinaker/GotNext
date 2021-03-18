<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Processes the login script.
-->
<?php
require 'connect.php';

$valid_login = true;

// Sanitize inputs.
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$query = "SELECT *
          FROM players
          WHERE email = '$email' AND password = '$password'";
$statement = $db->prepare($query);
$statement->execute();
$players = $statement->fetchAll();

require 'header.php';

// Check if the user exists.
if (count($players) === 1) {
  $valid_login = true;

  $_SESSION['fname'] = $players[0]['FName'];
  $_SESSION['lname'] = $players[0]['LName'];
  $_SESSION['id'] = $players[0]['PlayerID'];
  $_SESSION['role'] = $players[0]['Role'];
} else {
  $valid_login = false;
}
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <?php if ($valid_login) : ?>
          <h1 class="fw-light">Logged In Successfully!</h1>
          <p>
            <a href="index.php" class="btn btn-primary my-2">View Games</a>
          </p>
        <?php else : ?>
          <h1 class="fw-light">There was an issue.</h1>
          <p class="lead text-muted">Please check your login details and try again.</p>
          <p>
            <a href="login.php" class="btn btn-primary my-2">Try Again</a>
          </p>
        <?php endif ?>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php'; ?>