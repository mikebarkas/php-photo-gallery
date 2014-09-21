<?php
require_once('../inc/initialize.php');
?>

<?php include('layout/header.php'); ?>

<h2>Photo Gallery</h2>
<p>Index page.</p>

<p>
<?php
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
</p>

<?php include('layout/footer.php'); ?>