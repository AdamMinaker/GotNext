<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Account registration script for GotNext.
-->
<?php
require 'header.php';
?>
<main>
  <div class="text-center">
    <h3 class="mb-4 mt-3">Register New Player</h3>
    <form action="process_registration.php" method="post">
      <input class="form-control mb-3" name="fname" id="fname" placeholder="First Name" required />
      <input class="form-control mb-3" name="lname" id="lname" placeholder="Last Name" required />
      <input class="form-control mb-3" type="email" name="email" id="email" placeholder="Email" required />
      <input class="form-control mb-3" type="password" name="password" id="password" placeholder="Password" required />
      <input class="form-control mb-3" type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required />
      <input class="btn btn-danger my-2" type="submit" name="command" value="Register" />
    </form>
  </div>
</main>
<?php
require 'footer.php';
?>