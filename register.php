<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Account registration script for GotNext.
-->
<?php require 'header.php'; ?>
<main>
  <div class="text-center">
    <h3 class="mb-4 mt-3">Register New Player</h3>
    <form action="process_registration.php" method="post" class="needs-validation" novalidate>
      <input class="form-control mt-3" name="fname" id="fname" placeholder="First Name" required />
      <div class="invalid-feedback">
        Please provide your first name.
      </div>
      <input class="form-control mt-3" name="lname" id="lname" placeholder="Last Name" required />
      <div class="invalid-feedback">
        Please provide your last name.
      </div>
      <input class="form-control mt-3" type="email" name="email" id="email" placeholder="Email" required />
      <div class="invalid-feedback">
        Please provide your email address.
      </div>
      <input class="form-control mt-3" type="password" name="password" id="password" placeholder="Password" required />
      <div class="invalid-feedback">
        Please provide a password.
      </div>
      <input class="form-control mt-3" type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required />
      <div class="invalid-feedback">
        Please repeat your password.
      </div>
      <input class="btn btn-danger my-2 mt-3" type="submit" name="command" value="Register" />
    </form>
  </div>
</main>
<?php require 'footer.php'; ?>