<!--https://bitbucket.org/czhang088/spring2017-module3-437121-452664/src/7da7a508d531a100932cf8302928e0e240989ecd/login.php?at=master&fileviewer=file-view-default-->

<?php
require 'database.php';
// Use a prepared statement
session_start();
$stmt = $mysqli->prepare("SELECT COUNT(*), username, pass_hash
						 FROM userpw
						 WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $username);
$username = $_POST['username'];
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $user, $pass);
$stmt->fetch();

$password = $_POST['password'];
// Compare the submitted password to the actual password hash
// In PHP < 5.5, use the insecure: if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
 
if($cnt == 1 && password_verify($password, $pass)){
	// Login succeeded
	$_SESSION['username'] = $user;
	echo "login successful";
	header('refresh:2 url=main.php ');

} else{
	echo "Login failed, please try again.";
	header('refresh:2; url=loginSignupPage.php ');

}
?>