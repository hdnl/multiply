<?php
//Include FB config file && User class
require_once '/home/pchan/www/multiply/lib/fbconfig.php';
require_once '/home/pchan/www/multiply/lib/user.php';

if(!$fbUser){
    $fbUser = NULL;
    $loginURL = $facebook->getLoginUrl(array('redirect_uri'=>$redirectURL,'scope'=>$fbPermissions));
    $output = '<a href="'.$loginURL.'"><img src="images/fblogin.png"></a>';     
}else{
    //Get user profile data from facebook
    $fbUserProfile = $facebook->api('/me?fields=id,first_name,last_name,email,link,gender,locale,picture');

    //Initialize User class
    $user = new User();
    
    //Insert or update user data to the database
    $fbUserData = array(
        'oauth_provider'=> 'facebook',
        'oauth_uid'     => $fbUserProfile['id'],
        'first_name'     => $fbUserProfile['first_name'],
        'last_name'     => $fbUserProfile['last_name'],
        'email'         => $fbUserProfile['email'],
        'gender'         => $fbUserProfile['gender'],
        'locale'         => $fbUserProfile['locale'],
        'picture'         => $fbUserProfile['picture']['data']['url'],
        'link'             => $fbUserProfile['link']
    );
    $userData = $user->checkUser($fbUserData);
    
    //Put user data into session
    $_SESSION['userData'] = $userData;
    
    //Render facebook profile data
    if(!empty($userData)){
        $output = '<h1>Facebook Profile Details </h1>';
        $output .= '<img src="'.$userData['picture'].'">';
        $output .= '<br/>Facebook ID : ' . $userData['oauth_uid'];
        $output .= '<br/>Name : ' . $userData['first_name'].' '.$userData['last_name'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Locale : ' . $userData['locale'];
        $output .= '<br/>Logged in with : Facebook';
        $output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Facebook Page</a>';
        $output .= '<br/>Logout from <a href="logout.php">Facebook</a>'; 
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Multiply</title>
<base href="http://multiply.projectsoft.org/">
<link rel="stylesheet" href="styles/multiply.css" type="text/css">
</head>

<body>
<div id="loginpage">
<div id="navigation">
<nav>
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="#">About Us</a></li>
		<li><a href="#">Subscribe</a></li>
	</ul>
</nav>
</div><!--.navigation-->

<header>
<img class="logo" src="images/logo.png" alt="logo">

<h1>Explore Today.</h1>
<p>Start Below.</p>
</header>

<main>
<!-- <p><img class="fblogin" src="images/fblogin.png" alt="fbplaceholder"></p> -->
<p class="fblogin"><?php echo $output; ?></p>

<div class="or-break">
<p>OR</p>
</div>

<div id="signup-form">
<form action="#" method="post">
<fieldset>
<input type="text" name="username" id="username" placeholder="username">
</fieldset>
<fieldset>
<input type="text" name="password" id="password" placeholder="password">
</fieldset>
<fieldset>
<input type="text" name="email" id="email" placeholder="email">
</fieldset>
<fieldset>
<input type="text" name="confirm" id="confirm" placeholder="confirm">
</fieldset>
<fieldset>
<input type="text" name="bday" id="bday" placeholder="bday">
</fieldset>
<fieldset>
<p class="agree"><input type="checkbox" name="agree" id="agree"> I agree to the <a href="#" onclick="event.preventDefault();">terms &amp; conditions*</a></p>
<input type="submit" name="signup" id="signup" value="Sign Up" onclick="event.preventDefault();">
</fieldset>
</form>
</div><!--.signup-form-->
</main>

<footer>
</footer>

<script src="scripts/fblogin.js"></script>

</div><!--.loginpage-->
</body>
</html>
