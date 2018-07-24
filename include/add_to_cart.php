<?php
/**
 * File:		add_to_cart.php
 * Author:		Adam Rozen
 * Purpose:		Add product to cart
 **/
if ($_SESSION['loggedIn']) {
    require("./include/connect.php");

    $product_id = $_POST['product_id'];

    $sql = $conn->stmt_init();
    $sql->prepare('SELECT blendID FROM coffeeBlends WHERE blendID = ?');
    $sql->bind_param("i", $product_id);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check for valid item
        if (!isset($row['blendID'])) {
            echo "Invalid item!<br />";
            die();
        }

        $stmt = $conn->stmt_init();
        $stmt->prepare('SELECT blendID FROM cart WHERE cart.userID = (SELECT userID FROM users WHERE userName = ?)');
        $stmt->bind_param('s', $_SESSION['loggedIn']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // If item already in cart, tell user
            while ($row = $result->fetch_assoc())
            {
                if ($row['blendID']==$product_id) {
                    echo "Item already in cart! <br>";
                    $flag = true;
                }
            }
        }
        // Otherwise add to cart
        if (!isset($flag)) {
            $stmt = $conn->stmt_init();
            $stmt->prepare('SELECT userID FROM users WHERE userName = ?');
            $stmt->bind_param('s', $_SESSION['loggedIn']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt = $conn->stmt_init();
            $stmt->prepare('INSERT INTO cart (userID, blendID, quantity) VALUES (?, ?, ?)');
            $stmt->bind_param('sii', $row['userID'], $product_id, $_POST['quantity']);
            $stmt->execute();
            echo "Added to cart";
        }
    }
    return;
}
else {
    echo "<h3 class='red'>Please login before using the cart feature</h3>";
}
?>
