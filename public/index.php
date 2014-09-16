<?php
require_once('../inc/database.php');

$sql = "select * from users where id = 1";
$result_set = $db->query($sql);
$found_user = $db->fetch_array($result_set);

echo $found_user['username'];
echo "<br/>";
echo $found_user['id'];
echo "<br/>";
echo $found_user['first_name'] . ' ' . $found_user['last_name'];
?>