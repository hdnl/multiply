<?php
session_start();

//Include Facebook SDK
require_once 'inc/facebook.php';

/*
 * Configuration and setup FB API
 */
$appId = '961815727287649'; //Facebook App ID
$appSecret = '96bef03ce12fbdb29551724d50b7594b'; // Facebook App Secret
$redirectURL = 'http://multiply.projectsoft.org/profile.php'; // Callback URL
//$fbPermissions = 'email';  
$fbPermissions = ['email', 'user_likes', 'user_friends', 'user_religion_politics']; //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret
));
$fbUser = $facebook->getUser();
?>
