<?php
require_once('../inc/initialize.php');


echo "<hr/>";

$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr/>";

$users = User::find_all();
foreach ($users as $user) {
  echo 'User: ' . $user->username . '<br/>';
  echo 'Name: ' . $user->full_name() . '<br/>';
}

?>
<?php include('layout/header.php'); ?>

<h1>Photo Gallery</h1>
<p>Index page.</p>

<?php include('layout/footer.php'); ?>