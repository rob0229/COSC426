<?php
//include config
require_once('includes/config.php');
//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); } 

//process login form if submitted
if(isset($_POST['submit'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user->login($username, $password);
	if($user->is_logged_in()){
		header('Location: index.php');
		exit;
	} else {
		$error[] = 'Wrong username or password or your account has not been activated.';
	}
}//end if submit
//define page title
$title = 'Login';
//include header template
require('includes/header.php'); 
require("includes/navbar.php");
?>
<div class="container">
	<h2>Login</h2>
	<form role="form" method="post" action="" autocomplete="off">
		<div id="loginPage">
			<?php
			//check for any errors
			if(isset($error)){
				foreach($error as $error){
					echo '<p class="bg-danger">'.$error.'</p>';
				}
			}
			if(isset($_GET['action'])){
				//check the action
				switch ($_GET['action']) {
					case 'active':
						echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
						break;
					case 'reset':
						echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
						break;
					case 'resetAccount':
						echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
						break;
					case 'mustLogIn':
						echo "<h2 class='bg-success'>You must log in to create a trip</h2>";
				}
			} ?>
			<input type="text" name="username" id="username" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>"><br/>
			<input type="password" name="password" id="password" placeholder="Password"><br/>
			<a href='reset.php'>Forgot your Password?</a><br/>
			<input type="submit" name="submit" id="submit" value="Login" class="btn"><br/>
		</div>
	</form>
</div>


<?php 
//include header template
require('includes/footer.php'); 
?>