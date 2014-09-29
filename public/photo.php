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

if (isset($_POST['submit'])) {
  $author = trim($_POST['author']);
  $body = trim($_POST['body']);

  $new_comment = Comment::make($photo->id, $author, $body);
  if ($new_comment && $new_comment->save()) {
    // Show in list. no $message
    // Redirect makes get request not post.
    redirect_to("photo.php?id={$photo->id}");
  } else {
    $message = 'Your comment could not be saved.';
  }
} else {
  $author = '';
  $body = '';
}
// If no post, get comments.
$comments = Comment::find_comments_on($photo->id);

?>

<?php include_layout_template('header.php'); ?>
<p><a href="display_photos.php">&laquo; Back</a></p>
<div>
  <img src="<?php echo $photo->image_path();?>" width="680" />
  <p class="caption"><?php echo $photo->caption;?></p>
</div>

<div class="comment-list">
  <?php foreach ($comments as $comment) : ?>
  <div class="comment">
    <p class="author"><?php echo htmlentities($comment->author); ?></p>
    <p class="body"><?php echo strip_tags($comment->body, '<strong><b><em><p>'); ?></p>
    <p class="created"><?php echo $comment->created;?></p>
  </div>
  <?php endforeach; ?>
  <?php if (empty($comments)) {echo "No comments.";} ?>

</div>

<div class="comment-form">
  <h3>New Comment</h3>
  <?php echo output_message($message); ?>
  <form action="photo.php?id=<?php echo $photo->id; ?>" method="post">
    <p>Your Name:<br/>
    <input type="text" name="author" value="<?php echo $author; ?>" /></p>
    <p>Your Comment:<br/>
    <p><textarea name="body" cols="30" rows="5"><?php echo $body; ?></textarea></p>
    <p><input type="submit" name="submit" value="Submit Comment" /></p>
  </form>
</div>

<?php include_layout_template('footer.php'); ?>