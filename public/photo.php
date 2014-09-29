<?php
require_once('../inc/initialize.php');
if (empty($_GET['id'])) {
  $session->message('No photograph ID was provided.');
  redirect_to('display_photos.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if (!$photo) {
  $session->message('The photo could not be located.');
  redirect_to('display_photos.php');
}
?>

<?php include_layout_template('header.php'); ?>
<p><a href="display_photos.php">&laquo; Back</a></p>
<div>
  <img src="<?php echo $photo->image_path();?>" width="680" />
  <p class="caption"><?php echo $photo->caption;?></p>
</div>

<!-- list comments -->

<?php include_layout_template('footer.php'); ?>