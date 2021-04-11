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
  <link href="css/main.css?v4.4" rel="stylesheet">
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
          <div class="mb-4">
            <div class="btn-group-vertical">
              <?php if (!isset($_SESSION['fname'])) : ?>
                <a href="login.php" class="btn btn-outline-danger">Login</a>
                <a href="register.php" class="btn btn-outline-danger">Register</a>
                <a href="index.php" class="btn btn-outline-danger">View Games</a>
              <?php elseif (isset($_SESSION['fname'])) : ?>
                <a href="index.php" class="btn btn-outline-danger">View Games</a>
                <?php if ($_SESSION['role'] === 'A') : ?>
                  <a href="admin.php" class="btn btn-outline-danger">All Users</a>
                  <a href="locations.php" class="btn btn-outline-danger">All Locations</a>
                <?php elseif ($_SESSION['role'] === 'U') : ?>
                  <a href="locations.php" class="btn btn-outline-danger">My Locations</a>
                <?php endif ?>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
              <?php endif ?>
            </div>
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