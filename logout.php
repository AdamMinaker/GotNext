<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Logout script for GotNext.
-->
<?php
require 'header.php';
session_destroy();
header('Location: index.php');
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Logged Out Successfully.</h1>
        <p>
          <a href="index.php" class="btn btn-primary my-2">View Games</a>
        </p>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php' ?>