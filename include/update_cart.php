<!--
 * File:		update_cart.php
 * Author:		Adam Rozen
 * Purpose:		Update cart
-->


<form action='?view_cart=1' method='post'>
<table style='width:500px;' cellspacing='0'>
    <tr style='border-bottom:1px solid #000000;'>
    <th style='border-bottom:1px solid #000000;'>Name</th>
    <th style='border-bottom:1px solid #000000;'>Price</th>
    <th style='border-bottom:1px solid #000000;'>Decaf</th>
    <th style='border-bottom:1px solid #000000;'>Quantity</th>
    </tr>
<?php
$st = $conn->stmt_init();
$st->prepare('SELECT blendID FROM cart WHERE userID = (SELECT userID from users WHERE userName = ?)');
$st->bind_param('s', $_SESSION['loggedIn']);
$st->execute();
$r = $st->get_result();
while ($rw = $r->fetch_assoc()) {
    $product_id = $rw['blendID'];
    $stmt = $conn->stmt_init();
    $stmt->prepare('SELECT quantity, caffeination, blendName, price FROM cart, coffeeBlends WHERE coffeeBlends.blendID = ? AND coffeeBlends.blendID = cart.blendID AND cart.userID = (SELECT userID FROM users WHERE userName = ?)');
    $stmt->bind_param('is', $product_id, $_SESSION['loggedIn']);
    $stmt->execute();
    $rs = $stmt->get_result();
    $row = $rs->fetch_assoc();
    $caf = $row['caffeination']==0 ? 'Decaf' : 'Regular';
    $qu = $row['quantity'];
    ?>
    <tr>
        <td style='font-weight:bold;border-bottom:1px solid #000000;'><a href='?view_product=<?=$product_id?>'><?=$row['blendName']?></a></td>
        <td style='border-bottom:1px solid #000000;'>&#36;<?=$row['price']?></td>
        <td style='border-bottom:1px solid #000000;'><?=$caf?></td>
        <td style='border-bottom:1px solid #000000;'>
        <input type='hidden' name='id' value='<?=$product_id?>'/>
        <input type='number' name='quantity[<?=$product_id?>]' value='<?=$row['quantity']?>' min='0' required /></td>
    </tr>
    <?php
    $rs->close();
}
echo "</table>
<input type='submit' name='update_cart' value='Update' />
</form>";

if (isset($_POST['update_cart'])) {
    $stmt = $conn->stmt_init();
    $quant = $_POST['quantity'][$_POST['id']];
    if ($quant <= 0){
        $stmt->prepare('DELETE FROM cart WHERE userID = (SELECT userID FROM users WHERE userName = ?) AND blendID = ?');
        $stmt->bind_param('si', $_SESSION['loggedIn'], $_POST['id']);
    }
    else {
        $stmt->prepare('UPDATE cart SET quantity = ? WHERE userID = (SELECT userID FROM users WHERE userName = ?) AND blendID = ?');
        $stmt->bind_param('isi', $quant, $_SESSION['loggedIn'], $_POST['id']);
    }
    $stmt->execute();
    header("Location: ./store.php?view_cart=1");
}

?>
