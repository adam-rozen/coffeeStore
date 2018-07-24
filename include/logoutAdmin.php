<?php

/**
 * File:		login.php
 * Author:		Adam Rozen
 * Purpose:	    login to account
 **/
session_start();

unset($_SESSION['admin']);

header("Location: ../store.php");
exit;
