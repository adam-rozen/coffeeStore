<?php

/**
 * File:		login_admin.php
 * Author:		Adam Rozen
 * Purpose:	    login to view admin stuff
 **/

session_start();

if (isset($_POST['login'])) {
    if ($_POST['user'] == 'admin') {
        if (!isset($_SESSION['admin'])) {
            if (password_verify($_POST['pass'], '$2y$10$GvrpOUuX03sBszFtQZe41OB/H2N.sIv7C14RbgIpsGnM67Gf/Yjv.'))
            {
                $_SESSION['admin'] = true;
            }
        }
    }
}
header('Location: ./../portal.php');
?>