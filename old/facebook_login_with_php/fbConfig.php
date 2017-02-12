<?php
session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = 'InsertAppID'; //Facebook App ID
$appSecret = 'InsertAppSecret'; // Facebook App Secret
$redirectURL = 'http://localhost/facebook_login_with_php/'; // Callback URL
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>