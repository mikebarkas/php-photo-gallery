<?php
require_once('../../inc/initialize.php');

if ($session->is_logged_in()) {
  redirect_to('index.php');
}

// Form submitted.
if (isset($_POST['submit'])) {

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Check db.
  $found_user = User::authenticate($username, $password);

  if ($found_user) {
    $session->login($found_user);
    log_action('Login', "{$found_user->username} logged in.");
    redirect_to('index.php');
  } else {
    $message = 'Username/password combination incorrect.';
  }
} else { // form not submitted
  $username = '';
  $password = '';
}
?>

<?php include('../layout/admin_header.php'); ?>

<h2>Log In</h2>
<form action"login.php" method="post">
  <p>Username:
  <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></p>
  <p>Password:
  <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></p>
  <input type="submit" name="submit" value="Login" />

</form>

<?php include('../layout/admin_footer.php'); ?>
