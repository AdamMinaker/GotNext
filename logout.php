<!--
  Author: Adam Minaker
  Date: 3/18/2021
  Description: Logout script for GotNext.
-->
<?php
require 'header.php';
session_destroy();
require 'footer.php';
header('Location: index.php?logout');
?>