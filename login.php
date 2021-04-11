<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Login script for GotNext.
-->
<?php require 'header.php'; ?>
<main>
  <div class="text-center">
    <h3 class="mt-3 mb-3">Login</h3>
    <form action="process_login.php" method="post" class="needs-validation" novalidate>
      <input class="form-control" type="email" name="email" id="email" placeholder="Email" required />
      <div class="invalid-feedback">
        Please provide your email address.
      </div>
      <input class="form-control mt-3" type="password" name="password" id="password" placeholder="Password" required />
      <div class="invalid-feedback">
        Please provide your password.
      </div>
      <input class="btn btn-danger my-2 mt-3" type="submit" name="command" value="Login" />
    </form>
  </div>
</main>
<?php require 'footer.php'; ?>