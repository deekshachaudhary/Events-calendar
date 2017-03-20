<!--https://bitbucket.org/czhang088/spring2017-module3-437121-452664/src/7da7a508d531a100932cf8302928e0e240989ecd/createNewUser.php?at=master&fileviewer=file-view-default-->

<?php
require 'database.php';
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $mysqli->prepare("SELECT username FROM userpw WHERE username=?");
 
// Bind the parameter
$stmt->bind_param('s', $username);
$username = $_POST['username'];
$stmt->execute();
 
// Bind the results
$stmt->bind_result($user);
$stmt->fetch();
$stmt -> close();

// Compare the submitted password to the actual password hash
// In PHP < 5.5, use the insecure: if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
 
if(strcmp($username, $user) == 0){
	echo "This username has been taken please try again.";
	header('refresh:2 url=loginSignupPage.php ');
	exit;
}

else{
$pass_hash = password_hash($password, PASSWORD_DEFAULT);

$store_user_pass = $mysqli->prepare("insert into userpw (username, pass_hash) values (?, ?)");

if(!$store_user_pass) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$store_user_pass->bind_param('ss', $username, $pass_hash);
$store_user_pass->execute();
$store_user_pass->close();
echo "Your account has be successfully created. Please login to continue.";
header('refresh:2 url=loginSignupPage.php ');
}
?>