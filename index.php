<!DOCTYPE html>
<html>
	<head>

		<style>

		.space-form{
			margin-top: 3px;
		}

		#imgpos {
			position: absolute;
			left: 500px;
			top: 500px;

			} 

		</style>

	</head>

<body>

<?php
//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'user.php';

if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    //Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();
    
    //Initialize User class
    $user = new User();
    
    //Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'gender'        => $gpUserProfile['gender'],
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
        'link'          => $gpUserProfile['link']
    );
    $userData = $user->checkUser($gpUserData);
    
    //Storing user data into session
    $_SESSION['userData'] = $userData;
    
    //Render facebook profile data
    if(!empty($userData)){
        $output = '<h2>Google+ Profile Details </h2>';
        $output .= '<img src="'.$userData['picture'].'" width="150" height="110">';
        $output .= '<br/>Google ID : ' . $userData['oauth_uid'];
        $output .= '<br/>Name : ' . $userData['first_name'].' '.$userData['last_name'];
        $output .= '<br/>Email : ' . $userData['email'];
        $output .= '<br/>Gender : ' . $userData['gender'];
        $output .= '<br/>Locale : ' . $userData['locale'];
        $output .= '<br/>Logged in with : Google';
        $output .= '<br/><a href="'.$userData['link'].'" target="_blank">Click to Visit Google+ Page</a>';
        $output .= '<br/>Logout from <a href="logout.php">Google</a>'; 
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
} else {
    $authUrl = $gClient->createAuthUrl();
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/glogin.png" alt=""/ id="imgpos"></a>';
}
?>

<div><?php echo $output; ?></div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div style="container-fluid">
	<title>Impact and Alternative Models!</title>
	<div class="row">
		<div class="col-sm-offset-2 text-center col-sm-8">
			<h1>Welcome to Impact and Alternative Models!</h1>
		</div>
	</div>

<script type="text/javascript" src="jquery-1.10.1.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>




<form id="form" action="login.php" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="row">
		<div class="col-sm-offset-4 col-sm-4">
			<!--<div class="row">
				<div class="col-sm-2">Name:</div><div class="col-sm-4"> <input type="text" name="name" ></div>
				<div class="input-group col-sm-8">
					<span class="input-group-addon">Nome</span>
					<input id="nome" type="text" class="form-control" name="nome">
				</div>
			</div>-->
			<h3>Already have an account? Sign in!</h3>
			<div class="row space-form">
				<!--<div class="col-sm-2">E-mail:</div><div class="col-sm-4"> <input type="email" name="email"></div>-->
				<div class="input-group col-sm-8">
   					 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    				<input id="email" type="text" class="form-control" name="email" placeholder="Email">
 				 </div>
			</div>
			<div class="row space-form">
				<!--<div class="col-sm-2">Password:</div><div class="col-sm-4"> <input type="password" name "password"></div>-->
				<div class="input-group col-sm-8">
    				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    				<input id="password" type="password" class="form-control" name="password" placeholder="Password">
  				</div>
			</div>
			<div class="row space-form">
				<div class="col-sm-8 text-center ">
					<button type="submit" class='btn btn-primary'> Login </button>
					<button type="reset" class='btn btn-primary'>Reset</button>


				</div>
			</div>
		</div>
		
	</div>	

</form>
<br>

<form id="formRegister" action="registro.php" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<div class="row">
		<div class="col-sm-offset-4 col-sm-4">
			<!--<div class="row">
				<div class="col-sm-2">Name:</div><div class="col-sm-4"> <input type="text" name="name" ></div>
				<div class="input-group col-sm-8">
					<span class="input-group-addon">Nome</span>
					<input id="nome" type="text" class="form-control" name="nome">
				</div>
			</div>-->
			<h3>Still do not have an account? Sign Up!</h3>
			<div class="row space-form">
				<!--<div class="col-sm-2">E-mail:</div><div class="col-sm-4"> <input type="email" name="email"></div>-->
				<div class="input-group col-sm-8">
   					 <span class="input-group-addon"><i class="glyphicon glyphicon-font"></i></span>
    				<input id="name" type="text" class="form-control" name="name" placeholder="Name">
 				 </div>
			</div>
			<div class="row space-form">
				<!--<div class="col-sm-2">E-mail:</div><div class="col-sm-4"> <input type="email" name="email"></div>-->
				<div class="input-group col-sm-8">
   					 <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
    				<input id="email" type="text" class="form-control" name="email" placeholder="Email">
 				 </div>
			</div>
			<div class="row space-form">
				<!--<div class="col-sm-2">Password:</div><div class="col-sm-4"> <input type="password" name "password"></div>-->
				<div class="input-group col-sm-8">
    				<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
    				<input id="password" type="password" class="form-control" name="password" placeholder="Password">
  				</div>
			</div>
			<div class="row space-form">
				<div class="col-sm-8 text-center ">
					<button type="submit" class='btn btn-primary'> Register </button>
					<button type="reset" class='btn btn-primary'>Reset</button>


				</div>
			</div>
		</div>
	</div>	
	</div>

</form>
		




</body>
</html>


