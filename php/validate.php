<?php

function sanitize_string($str) {
  $res = filter_var($str, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if($res === FALSE) return null;
  return $res;
}

function sanitize_input_string($type, $var) {
  $res = filter_input($type, $var, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if($res === FALSE) return null;
  return $res;
}

function validate_input_mail($type, $var) {
  $res = filter_input($type, $var, FILTER_VALIDATE_EMAIL);
  if($res === FALSE) return null;
  return $res;
}

function sanitize_input_date($type, $var, $opt = null) {
  $date = sanitize_input_string($type, $var);
  if ($date === null) {
    return null;
  }
  $t = strtotime($date);
  if (FALSE === $t) {
    return null;
  }
  $date = date('Y-m-d', $t);
  list($year, $month, $day) = explode('-', $date);
  if (checkdate($month, $day, $year)) {
    if (!$opt) return $date;
    if (isset($opt['max']) && strtotime($opt['max']) && strtotime($opt['max']) < $t) return null;
    if (isset($opt['min']) && strtotime($opt['min']) && strtotime($opt['min']) > $t) return null;
    return $date;
  }
  return null;
}

function sanitize_input_time($type, $var) {
  $time = sanitize_input_string($type, $var);
  if ($time === null) {
    return null;
  }
  $t = strtotime($time);
  if (FALSE === $t) {
    return null;
  }
  return date('H:i:s', $t);
}

function sanitize_input_int($type, $var) {
  $res = filter_input($type, $var, FILTER_SANITIZE_NUMBER_INT);
  if($res === FALSE) return null;
  return $res;
}

function sanitize_input_float($type, $var) {
  $res = filter_input($type, $var, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  if($res === FALSE) return null;
  return $res;
}

function sanitize_input_bool($type, $var) {
  if ($type === INPUT_POST && isset($_POST[$var])
    || $type === INPUT_GET && isset($_GET[$var])) {
    return filter_input($type, $var, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
  }
  return null;
}

function sanitize_input_set($type, $var, $set) {
  $res = sanitize_input_string($type, $var);
  if (in_array($res, $set, TRUE)) {
    return $res;
  }
  return null;
}
