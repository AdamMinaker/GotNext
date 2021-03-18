<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Account registration script for GotNext.
-->
<?php
require 'header.php';
?>
<main>
  <form action="process_registration.php" method="post">
    <fieldset>
      <legend>Register</legend>
      <p>
        <label for="fname">First Name</label>
        <input name="fname" id="fname" />
      </p>
      <p>
        <label for="lname">Last Name</label>
        <input name="lname" id="lname" />
      </p>
      <p>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" />
      </p>
      <p>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" />
      </p>
      <p>
        <label for="cpassword">Confirm Password</label>
        <input type="password" name="cpassword" id="cpassword" />
      </p>
      <p>
        <input type="submit" name="command" value="Register" />
      </p>
    </fieldset>
  </form>
</main>
<?php
require 'footer.php';
?>