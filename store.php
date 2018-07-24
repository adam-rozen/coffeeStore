<?php
/**
 * File:		store.php
 * Author:		Adam Rozen
 * Purpose:		View Store
 **/
session_start();

// Initialize loggedIn
if (!isset($_SESSION['loggedIn'])) {
  //  $_SESSION['loggedIn'] = NULL;
}

// Empty cart
if (isset($_GET['empty_cart'])) {
    if (isset($_SESSION['loggedIn'])) {
        require_once 'include/connect.php';
        $stmt = $conn->stmt_init();
        $stmt->prepare('DELETE FROM cart WHERE userID = (SELECT userID FROM users WHERE userName = ?)');
        $stmt->bind_param('s', $_SESSION['loggedIn']);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
}

include("./include/header1.php");

if (isset($_POST['add_to_cart'])) {
    include("./include/add_to_cart.php");
}

if (isset($_GET['view_product'])) {
    include("./include/view_product.php");
}
elseif (isset($_GET['view_cart'])) {
    include("./include/view_cart.php");
}
elseif (isset($_GET['checkout'])) {
	echo "Coming Soon<br>";
	echo "<a href='?view_cart=1'>Go Back</a>";
}
else {
    include("./include/show_products.php");
}



include("./include/footer.php");
?>
