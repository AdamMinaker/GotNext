<!--
  Author: Adam Minaker
  Date: 3/10/2021
  Description: Header script for GotNext.
-->
<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GotNext</title>
  <link href="css/bootstrap.min.css?v1.0" rel="stylesheet">
  <link href="css/main.css?v4.1" rel="stylesheet">
</head>

<body>
  <header>
    <div class="collapse bg-dark" id="navbarHeader">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-md-7 py-4">
            <?php if (!isset($_SESSION['fname'])) : ?>
              <p class="text-white">A free medium for basketball players to organize and join games on public courts.<br>Register or login to create and join games!</p>
            <?php elseif (isset($_SESSION['fname'])) : ?>
              <p class="text-white">Hello, <?= $_SESSION['fname'] ?>!</p>
            <?php endif ?>
          </div>
          <div class="col-sm-4 offset-md-1 py-4">
            <ul class="list-unstyled">
              <?php if (!isset($_SESSION['fname'])) : ?>
                <li><a href="login.php" class="text-white">Login</a></li>
                <li><a href="register.php" class="text-white">Register</a></li>
                <li><a href="index.php" class="text-white">View Games</a></li>
              <?php elseif (isset($_SESSION['fname'])) : ?>
                <li><a href="index.php" class="text-white">View Games</a></li>
                <?php if ($_SESSION['role'] === 'A') : ?>
                  <li><a href="admin.php" class="text-white">All Users</a></li>
                  <li><a href="locations.php" class="text-white">All Locations</a></li>
                <?php elseif ($_SESSION['role'] === 'U') : ?>
                  <li><a href="locations.php" class="text-white">My Locations</a></li>
                <?php endif ?>
                <li><a href="logout.php" class="text-white">Logout</a></li>
              <?php endif ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
      <div class="container">
        <a href="index.php" class="navbar-brand d-flex align-items-center">
          <img id="logo" src="GotNext.png" alt="GotNext Logo" width="30" height="30">
          <strong style="padding-left: 10px; color: #EA5455">GotNext</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </div>
  </header>