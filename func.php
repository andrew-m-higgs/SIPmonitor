<?php
include_once('config.php');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set("display_errors", 1);
ob_start();
session_start();

function get_db() {
  global $dbname, $dbhost, $dbuser, $dbpass;
  $link = mysql_connect($dbhost,$dbuser,$dbpass);
  mysql_select_db($dbname);
  return $link;
}

function get_sip_response($id) {
  global $sip_response;
  if (array_key_exists($id, $sip_response))
    return $sip_response[$id];
  else
    return 'Unknown code';
}

function get_sip_payload($id) {
  global $sip_payload;
  if (array_key_exists($id, $sip_payload))
    return $sip_payload[$id];
  else
    return 'Unknown codec';
}
?>
