<!--
  Author: Adam Minaker
  Date: 3/16/2021
  Description: Handles location post requests sent to the web server.
  TODO: Image resizing.
-->
<?php
require 'connect.php';

// Sanitize post superglobals.
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$file_upload_detected = isset($_FILES['file']) && ($_FILES['file']['error'] === 0);

if ($file_upload_detected) {
  $filename = $_FILES['file']['name'];
  $temporary_file_path = $_FILES['file']['tmp_name'];
  $new_file_path = file_upload_path($filename);

  if (file_is_an_image($temporary_file_path, $new_file_path)) {
    move_uploaded_file($temporary_file_path, $new_file_path);

    $image_path = 'image/' . $filename;

    // Insert location name and image path into the database.
    $query = "INSERT INTO locations (Name, Image) 
              VALUES (:name, :image)";
    $statement = $db->prepare($query);
    $statement->bindvalue(':name', $name);
    $statement->bindvalue(':image', $image_path);
    $statement->execute();

    header('Location: new_game.php');
  }
}

function file_is_an_image($temporary_path, $new_path) {
  $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
  $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

  $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
  $actual_mime_type = mime_content_type($temporary_path);

  $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
  $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

  return $file_extension_is_valid && $mime_type_is_valid;
}

function file_upload_path($original_filename, $upload_subfolder_name = 'image') {
  $current_folder = dirname(__FILE__);
  $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
  return join(DIRECTORY_SEPARATOR, $path_segments);
}

require 'header.php';
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">An error occured.</h1>
        <p class="lead text-muted">Please make sure you submit a location name and image.</p>
        <p class="lead text-muted">Images must be in jpg, gif, or png format.</p>
        <p>
          <a href="index.php" class="btn btn-primary my-2">Go Back</a>
        </p>
      </div>
    </div>
  </section>
</main>
<?php
require 'footer.php';
?>