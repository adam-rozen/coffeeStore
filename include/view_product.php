<?php
/**
 * File:		view_cart.php
 * Author:		Adam Rozen
 * Purpose:		View one product
 **/


require("connect.php");

$product_id = $_GET['view_product'];
$stmt = $conn->stmt_init();
if ($stmt->prepare("SELECT * FROM coffeeBlends WHERE blendID = ?")) {
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $page = $row['caffeination'] == "0" ? "Decaf" : "Regular";

        // Display site links
        echo "<p>
            <a href='./store.php?caffine=" . strtolower($page) . "&beans=all&filter=Filter'>$page</a>
            </p>";

        // Display Products
        echo "<p>
            <span style='font-weight:bold;'>" . $row['blendName'] . "</span><br>
            <span>&#36;{$row['price']}</span><br>
            <span>{$row['coffeeDescription']}</span><br>
            <p>
            <form action='?view_product=$product_id' method='post'>
                <select name ='quantity'>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                </select>
                <input type='hidden' name='product_id' value='$product_id' />
                <input type='submit' name='add_to_cart' value='Add to cart' />
            </form>
            </p>";

        echo "</p>";
    }
    else {
        echo "Invalid product!";
    }
    $result->close();
}
$conn->close();

?>
