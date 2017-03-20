<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Calendar Login</title>
    </head>
    <body>
        <h1>Welcome to CSE330 Calendar!</h1>
        <div id="loginForm">
            <fieldset>
            <form action="login.php" method='POST'>
                 <legend>Login</legend>
                 <label><b>Username</b></label>
                 <input name="username" placeholder="Enter Username" required="" type="text">
                 <label><b>Password</b></label>
                 <input name= "password" placeholder = "Enter Password" required= "" type ="password">
                 <input type="submit" value="Login">
           </form>

            <form action = "createNewUser.php" method = 'Post'>
            <legend>New User?</legend>
            <label><b>Username</b></label>
            <input name = "username" placeholder = "Create Username" required ="" type = "text">
            <label><b>Password</b></label>
            <input name= "password" placeholder = "Enter Password" required= "" type ="password">
            <input type = "submit" value = "Sign up">
            </form>
            </fieldset>
        </div>
    </body>
</html>
      