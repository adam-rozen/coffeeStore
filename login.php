<?php

/**
 * File:		login.php
 * Author:		Adam Rozen
 * Purpose:	    login to account
 **/
session_start();

require("./include/header1.php");
require("./include/functions.php");

if (!isset($_SESSION['loggedIn'])) {
    if (isset($_POST['login'])) {
        require('./include/connect.php');
        login($conn, $_POST['user'], $_POST['pass']);
    }
    elseif (isset($_POST['reg'])) {
        require('./include/register.php');
    }
}
else {
    header('Location: ./store.php');
}

?>

<div style='width:25%;float:left;'>
    <form action='' method='post'>
        <p>Username: <input type="text" name='user' value='' required/></p>
        <p>Password: <input type="password" name='pass' value='' required/></p>
        <p style='text-align:center;'><input type='submit' name='login' value='Login' /></p>
    </form>
</div>
<div style='width:25%;float:right;'>
    <form action='' method="post">
        <p>Email:&nbsp;<input type="email" name='email' value='' required/></p>
        <p>Username:&nbsp;<input type="text" name='user' value='' required/></p>
        <p>Password:&nbsp;<input type="password" name='pass' value='' required/></p>
        <p style='text-align:center;'><input type="submit" name='reg' value="Register"></p>
    </form>
</div>
<div style='clear:both'/>

<?php require("./include/footer.php") ?>