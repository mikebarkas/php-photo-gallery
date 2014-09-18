<?php
require_once('../../inc/functions.php');
require_once('../../inc/session.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}
?>
<?php include('../layout/admin_header.php'); ?>


<h1>Photo Gallery Admin</h1>

<?php include('../layout/admin_footer.php'); ?>