<?php
require_once('core/init.php');
$user = new User;
$toast = Toast::get();
$user->check_login();
$token = $_REQUEST['token'];
$user->check_token($token);
