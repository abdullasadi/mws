<?php
require_once('inc/middleware.php');


$api = new API;

if(Config::get('base.request_method') == 'POST') {
  if($_POST['type'] == 'dvr_action') {
    $start = ($_POST['start'] - 1) * 100;
    $api->dvr_api($start);
  }
}


if(Config::get('base.request_method') == 'POST') {
  if($_POST['type'] == 'dvr_import') {
    $id = $_POST['p_id'];
    $api->dvr_import($id);
  }
}
