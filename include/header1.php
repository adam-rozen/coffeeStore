<!--
 * File:    header1.php
 * Author:  Adam Rozen
 * Contains HTML blocks of layout
 -->

<!doctype HTML>
<html>
<head>
    <title>Chad &amp; Dad Coffee</title>
    <link rel='stylesheet' type='text/css' href='./include/style.css' />
</head>
<body>
    <div id='container'>
        <div id='header'>
            <h2 id='welcome'>Welcome to Chad &amp; Dad Coffee!</h2>
            <p id='center'><a href='./store.php'>Home</a></p>
            <span><a id='cart' href='./store.php?view_cart=1'>View Cart</a>
            <?php
                $header = "";
                if (!isset($_SESSION["loggedIn"])) {
                    $header .= "<a id='floatR' href='./login.php'>Login</a></span>";
                }
                else {
                    $header .= "<a id='floatR' href='./profile.php'>Profile</a><img src='./include/getProfilePic.php' id='pic'  width='50px' height='50px'></span>";
                }
                $header .= "<br><br></div><div id='content'>";
                echo $header;
            ?>
