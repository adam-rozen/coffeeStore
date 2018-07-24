<?php
/**
 * File:		view_cart.php
 * Author:		Adam Rozen
 * Purpose:		View cart
 **/

require("./include/connect.php");

if (isset($_SESSION['loggedIn'])) {
    if ($_SESSION['loggedIn']) {
        $stmt = $conn->stmt_init();
        $stmt->prepare("SELECT COUNT(userID) cnt FROM cart WHERE userID = (SELECT userID FROM users WHERE userName = ?)");
        $stmt->bind_param('s', $_SESSION['loggedIn']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($row['cnt'] == 0) {
                echo "Your cart is empty.<br />";
                echo "<a href='./store.php'>Go Shopping!</a>";
            }
            else {
                echo "<h3>Your Cart</h3>
                <p>
                    <a href='?empty_cart=1'>Empty Cart</a>
                </p>";

                //update cart
                require("./include/update_cart.php");

                echo "<p>
                    <a href='?checkout=1'>Checkout</a>
                </p>";
            }
            include("./include/footer.php");
            exit;
        }
    }
}

?>
<h3 class='red'>You do not have permission to view this page, please login first!</h3>
