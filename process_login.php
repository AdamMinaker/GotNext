<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Processes the login script.
-->
<?php
require 'connect.php';

// Sanitize inputs.
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$query = "SELECT FName, LName, PlayerID, Role, Password
          FROM players
          WHERE Email = :Email";
$statement = $db->prepare($query);
$statement->bindvalue(':Email', $email);
$statement->execute();
$players = $statement->fetchAll();

require 'header.php';

// Verify password and check if the user exists.
if (!empty($players)) {
  if (password_verify($password, $players[0]['Password']) && count($players) === 1) {
    $valid_login = true;

    $_SESSION['fname'] = $players[0]['FName'];
    $_SESSION['lname'] = $players[0]['LName'];
    $_SESSION['id'] = $players[0]['PlayerID'];
    $_SESSION['role'] = $players[0]['Role'];

    header('Location: index.php?login');
  }
}
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">There was an issue.</h1>
        <p class="lead text-muted">Please check your login details and try again.</p>
        <p>
          <a href="login.php" class="btn btn-danger my-2">Try Again</a>
        </p>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php'; ?>