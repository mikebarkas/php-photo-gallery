<?php
require_once('../../inc/initialize.php');
if (!$session->is_logged_in()) {redirect_to('login.php');}
?>
<?php include('../layout/admin_header.php'); ?>


<h2>Test add user</h2>


<?php
// Create user.
//$user = new User();
//$user->username = "mike";
//$user->password = 'password';
//$user->first_name = 'Mike';
//$user->last_name = 'Test';
//$user->create();

// Update user.
//$user = User::find_by_id(2);
//$user->password = 'password';
//$user->save();

// Delete user.
//$user = User::find_by_id(2);
//$user->delete();
// after db deletion, class instance still exists.
//echo $user->first_name . " was deleted.";

?>

<?php include('../layout/admin_footer.php'); ?>