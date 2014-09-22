<?php
require_once('../../inc/initialize.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}
?>
<?php
  $max_file_size = 1048576;
  $message = '';

  if (isset($_POST['submit'])) {
    $photo = new Photograph;
    $photo->caption = $_POST['caption'];
    $photo->attach_file($_FILES['file_upload']);
    if ($photo->save()) {
      $message = "Photograph uploaded successfully.";
    } else {
      $message = join("<br/>", $photo->errors);
    }
  }
?>
<?php include('../layout/admin_header.php'); ?>

<h2>Photo Upload</h2>
<?php echo output_message($message); ?>
<form action="photo_upload.php" enctype="multipart/form-data" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
  <p>Photo: <input type="file" name="file_upload" /></p>
  <p>Caption: <input type="text" name="caption" value=""></p>
  <input type="submit" name="submit" value="Upload" />
</form>




<?php include('../layout/admin_footer.php'); ?>