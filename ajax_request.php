<?php
require_once('inc/middleware.php');


$api = new API;
$petra = new PetraApi;

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

if(Config::get('base.request_method') == 'POST') {
  if($_POST['type'] == 'petra_data') {
    $start = ($_POST['start'] - 1) * 100;
    $petra->get_data($start);
  }
}
