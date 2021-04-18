<!--
  Author: Adam Minaker
  Date: 3/16/2021
  Description: Handles location post requests sent to the web server.
-->
<?php
require 'connect.php';
require 'header.php';

// Sanitize post superglobal.
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$location_id = filter_input(INPUT_POST, 'location_id', FILTER_SANITIZE_NUMBER_INT);

$file_upload_detected = isset($_FILES['file']) && ($_FILES['file']['error'] === 0);
$acceptable_file_type = true;
$image_path = '';

if ($_POST['command'] === 'Add Court') {
  if ($file_upload_detected) {
    $filename = $_FILES['file']['name'];
    $temporary_file_path = $_FILES['file']['tmp_name'];
    $new_file_path = file_upload_path($filename);

    if (file_is_an_image($temporary_file_path, $new_file_path)) {
      move_uploaded_file($temporary_file_path, $new_file_path);
      $image_path = 'image/' . $filename;
    } else {
      $acceptable_file_type = false;
    }
  }

  if (!empty($name) && $acceptable_file_type) {
    // Insert location name and image path into the database.
    $query = "INSERT INTO locations (PostedBy, Name, Image) 
              VALUES (:postedby, :name, :image)";
    $statement = $db->prepare($query);
    $statement->bindvalue(':postedby', $_SESSION['id']);
    $statement->bindvalue(':name', $name);
    $statement->bindvalue(':image', $image_path);
    $statement->execute();

    if (isset($_GET['new-game'])) {
      header('Location: new_game.php');
    } elseif (isset($_GET['locations'])) {
      header('Location: locations.php');
    }
  }
}

if ($_POST['command'] === 'Delete') {
  $query = "SELECT Image
            FROM locations
            WHERE LocationID = :location_id";
  $statement = $db->prepare($query);
  $statement->bindvalue(':location_id', $location_id);
  $statement->execute();
  $location_image = $statement->fetch();

  $file_name = $location_image['Image'];

  unlink($file_name);

  $query = "DELETE FROM locations 
            WHERE LocationID = :LocationID";
  $statement = $db->prepare($query);
  $statement->bindvalue(':LocationID', $location_id, PDO::PARAM_INT);
  $statement->execute();

  header('Location: locations.php');
}

if ($_POST['command'] === 'Save Changes') {
  if ($file_upload_detected) {
    $filename = $_FILES['file']['name'];
    $temporary_file_path = $_FILES['file']['tmp_name'];
    $new_file_path = file_upload_path($filename);

    if (file_is_an_image($temporary_file_path, $new_file_path)) {
      move_uploaded_file($temporary_file_path, $new_file_path);
      $image_path = 'image/' . $filename;
    } else {
      $acceptable_file_type = false;
    }
  }

  if (!empty($name) && !$file_upload_detected) {
    $query = "UPDATE locations 
              SET Name = :name
              WHERE LocationID = :location_id";
    $statement = $db->prepare($query);
    $statement->bindvalue(':location_id', $location_id);
    $statement->bindvalue(':name', $name);
    $statement->execute();
  }

  if (!empty($name) && $acceptable_file_type && $file_upload_detected) {
    $query = "UPDATE locations 
              SET Name = :name, Image = :image
              WHERE LocationID = :location_id";
    $statement = $db->prepare($query);
    $statement->bindvalue(':location_id', $location_id);
    $statement->bindvalue(':name', $name);
    $statement->bindvalue(':image', $image_path);
    $statement->execute();
  }

  if (isset($_POST['remove_image'])) {
    $query = "SELECT Image
              FROM locations
              WHERE LocationID = :location_id";
    $statement = $db->prepare($query);
    $statement->bindvalue(':location_id', $location_id);
    $statement->execute();
    $location_image = $statement->fetch();

    $file_name = $location_image['Image'];

    unlink($file_name);

    $query = "UPDATE locations 
              SET Image = null
              WHERE LocationID = :location_id";
    $statement = $db->prepare($query);
    $statement->bindvalue(':location_id', $location_id);
    $statement->execute();
  }

  header('Location: locations.php');
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
?>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">An error occured.</h1>
        <p class="lead text-muted">Please make sure you submit a location name.</p>
        <p class="lead text-muted">Images must be in jpg, gif, or png format.</p>
        <p>
          <a href="locations.php" class="btn btn-danger my-2">Go Back</a>
        </p>
      </div>
    </div>
  </section>
</main>
<?php require 'footer.php'; ?>