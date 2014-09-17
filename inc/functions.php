<?php

// Autoload attempt.
function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = "../inc/{$class_name}.php";
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

// Remove leading zeros from dates.
function strip_zeros_from_date($marked_string = '') {
  // Remove marked zeros.
  $no_zeros = str_replace('*0', '', $marked_string);
  // Remove remainig marks.
  $clean_string = str_replace('*', '', $no_zeros);
  return $clean_string;
}

?>