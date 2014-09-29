<?php
require_once('../../inc/initialize.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}

if (empty($_GET['id'])) {
  $session->message('No photograph ID was provided.');
  redirect_to('display_photos.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if (!$photo) {
  $session->message('The photo could not be located.');
  redirect_to('display_photos.php');
}

$comments = $photo->comments();

?>

<?php include_layout_template('admin_header.php'); ?>
  <p><a href="display_photos.php">&laquo; Back</a></p>

  <h3>Comments on <?php echo $photo->filename; ?></h3>

  <div class="comment-list">
  <?php foreach ($comments as $comment) : ?>
    <div class="comment">
      <p class="author"><?php echo htmlentities($comment->author); ?></p>
      <p class="body"><?php echo strip_tags($comment->body, '<strong><b><em><p>'); ?></p>
      <p class="created"><?php echo $comment->created;?></p>
      <p class="delte"><a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete Comment</a></p>
    </div>
  <?php endforeach; ?>
  <?php if (empty($comments)) {echo "No comments.";} ?>





<?php include_layout_template('admin_footer.php'); ?>