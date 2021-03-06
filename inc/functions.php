<?php

// Autoload attempt.
function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if (file_exists($path)) {
    require_once($path);
  } else {
    die("The file {$class_name}.php could not be found.");
  }
}

// Redirect page.
function redirect_to($location = NULL) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

// Output a message.
function output_message($message = '') {
  if (!empty($message)) {
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

// Include template layouts.
function include_layout_template($template="") {
  include(SITE_ROOT.DS.'public'.DS.'layout'.DS.$template);
}

// Remove leading zeros from dates.
function strip_zeros_from_date($marked_string = '') {
  // Remove marked zeros.
  $no_zeros = str_replace('*0', '', $marked_string);
  // Remove remainig marks.
  $clean_string = str_replace('*', '', $no_zeros);
  return $clean_string;
}

// Create login action log.
function log_action($action, $message = '') {
  $logfile = SITE_ROOT.DS.'logs/log.txt';
  $new = file_exists($logfile) ? false : true;
  if ($handle = fopen($logfile, 'a')) {
    if (is_writable($logfile)) {
      $logtime = strftime('%m-%d-%Y %H:%M', time());
      $content = "{$logtime} | {$action} : {$message}\n";
      fwrite($handle, $content);
      fclose($handle);
      if ($new) { chmod($logfile, 0755); }
    } else {
      echo 'Could not open log file writing.';
    }
  }
}

?>