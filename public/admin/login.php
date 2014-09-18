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
    redirect_to('index.php');
  } else {
    $message = 'Username/password combination incorrect.';
  }
} else { // form not submitted
  $username = '';
  $password = '';
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

<form action"login.php" method="post">
  Username:
  <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /><br/>
  Password:
  <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /><br/>
  <input type="submit" name="submit" value="Login" />

</form>

</body>
</html>
<?php if (isset($db)) { $db->close_connection(); } ?>