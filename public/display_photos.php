<?php
require_once('../inc/initialize.php');
$photos = Photograph::find_all();
?>

<?php include_layout_template('header.php'); ?>
<h2>Photographs</h2>

<?php foreach ($photos as $photo) : ?>
  
  <div class="photo">
  <a href="photo.php?id=<?php echo $photo->id; ?>" title="<?php echo $photo->caption;?>">
    <img src="../<?php echo $photo->image_path(); ?>" width="400"/>
  </a>
  <p class="caption"><?php echo $photo->caption; ?></p>
  </div>

<?php endforeach; ?>

<?php include_layout_template('footer.php'); ?>