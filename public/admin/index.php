<?php
require_once('../../inc/functions.php');
require_once('../../inc/session.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}
?>
<?php include('../layout/admin_header.php'); ?>


<h2>Admin Index</h2>

<?php include('../layout/admin_footer.php'); ?>