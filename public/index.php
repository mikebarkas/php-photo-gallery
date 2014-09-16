<?php
require_once('../inc/database.php');

//if (isset($database)) { echo 'true';} else { echo 'false';}




//$sql = "insert into users(id, username, password, first_name, last_name) ";
//$sql .= "values(1, 'admin', 'password', 'System', 'Administrator')";
//$result = $db->query($sql);

$sql = "select * from users where id = 1";
$result_set = $db->query($sql);
$found_user = mysql_fetch_array($result_set);

echo $found_user['username'];
echo "<br/>";
echo $found_user['id'];
echo "<br/>";
echo $found_user['first_name'] . ' ' . $found_user['last_name'];
?>