<?php
require_once('../../inc/initialize.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}

$photos = Photograph::find_all();

?>

<?php include_layout_template('admin_header.php'); ?>
<h2>Photographs</h2>
<p><?php echo output_message($message); ?></p>
<table>
  <tr>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>
    <th></th>
  </tr>
<?php foreach ($photos as $photo) : ?>
  
  <tr>
    <td><img src="../<?php echo $photo->image_path(); ?>" width="80"/></td>
    <td><?php echo $photo->filename; ?></td>
    <td><?php echo $photo->caption; ?></td>
    <td><?php echo $photo->size_as_text(); ?></td>
    <td><?php echo $photo->type; ?></td>
    <td><a href="delete_photo.php?id=<?php echo $photo->id;?>">Delete</a></td>
  </tr>
<?php endforeach; ?>

</table>
<p><a href="photo_upload.php">Upload a photo</a></p>

<?php include_layout_template('admin_footer.php'); ?>