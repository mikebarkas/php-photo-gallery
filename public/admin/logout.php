<?php
require_once('../../inc/initialize.php');
if ($session->is_logged_in()) {
  $session->logout();
}
redirect_to('index.php');
?>