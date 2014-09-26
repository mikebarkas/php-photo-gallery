<?php
require_once('../../inc/initialize.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}

// Must provide ID.
if (empty($_GET['id'])) {
  $session->message('No photograph ID was provided.');
  redirect_to('list_photos.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if ($photo && $photo->destroy()) {
  $session->message("<p class=\"message\">The photo <span class=\"deleted-file-name\">{$photo->filename}</span> was deleted.</p>");
  redirect_to('list_photos.php');
} else {
  $session->message('The photo could not be deleted.');
  redirect_to('list_photos.php');
}

if (isset($db)) { $db->close_connection(); }
?>