<?php

/**
 * File:		login.php
 * Author:		Adam Rozen
 * Purpose:	    login to account
 **/
session_start();

unset($_SESSION['loggedIn']);

header("Location: ../store.php");
exit;
