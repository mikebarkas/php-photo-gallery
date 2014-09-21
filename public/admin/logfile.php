<?php
require_once('../../inc/initialize.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}

$logfile = '../../logs/log.txt';

if ($_GET['clear'] == true) {
  // Clear log.
  file_put_contents($logfile, '');
  // Log it was cleared.
  log_action('Logs cleared', "by User ID {$session->user_id}");
  // Remove external parameter.
  redirect_to('logfile.php');
}
?>

<?php include('../layout/admin_header.php'); ?>

<h2>Log File</h2>
<p><a class="button" href="logfile.php?clear=true">Clear Logs</a></p>

<?php
if (file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r')) {
  echo '<div class="logs">';
  echo '<ul class="log-entries">';
  while (!feof($handle)) {
    $entry = fgets($handle);
    if (trim($entry) != '') {
      echo '<li>' . $entry . '</li>';
    }
  }
} else {
  echo 'Log file not readable.';
}
?>

<?php include('../layout/admin_footer.php'); ?>