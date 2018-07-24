<?php
/**
 * File:		show_products.php
 * Author:		Adam Rozen
 * Purpose:		View products
 **/
include("connect.php");

if(isset($_GET['filter'])) {
    if ($_GET['caffine']==='all') {
        $value1 = 'all';
        $value2 = 'regular';
        $value3 = 'decaf';
    }
    elseif ($_GET['caffine']==='regular') {
        $value1 = 'regular';
        $value2 = 'all';
        $value3 = 'decaf';
    }
    elseif ($_GET['caffine']==='decaf') {
        $value1 = 'decaf';
        $value2 = 'all';
        $value3 = 'regular';
    }
    else {
        echo "Bad GET Value";
        die();
    }
}
else {
    $value1 = 'all';
    $value2 = 'regular';
    $value3 = 'decaf';
}

echo "<h3>Our Products</h3>
<form method='get' action=''>
    <select name='caffine'>
        <option value=" . $value1 . ">" . ucfirst($value1) . "</option>
        <option value=" . $value2 . ">" . ucfirst($value2) . "</option>
        <option value=" . $value3 . ">" . ucfirst($value3) . "</option>
    </select>
    <select name='beans'>
        <option value='all'>Coming Soon</option>
    </select>
    <input type='submit' name='filter' value='Filter' />
</form>
<table cellspacing='0'>
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Caffeination</th>
</tr>
";

if (isset($_GET['filter'])) {
    $sql = $conn->stmt_init();
    if ($_GET['caffine']==='all') {
        $sql->prepare("SELECT blendID, blendName, price, caffeination, visible, active FROM coffeeBlends WHERE visible = 1 AND active = 1");
    }
    elseif ($_GET['caffine']==='regular') {
        $caff = '1';
        $sql->prepare("SELECT blendID, blendName, price, caffeination, visible, active FROM coffeeBlends WHERE caffeination = ? AND visible = 1 AND active = 1");
        $sql->bind_param("i", $caff);
    }
    elseif ($_GET['caffine']==='decaf') {
        $caff = '0';
        $sql->prepare("SELECT blendID, blendName, price, caffeination, visible, active FROM coffeeBlends WHERE caffeination = ? AND visible = 1 AND active = 1");
        $sql->bind_param("i", $caff);
    }
    else {
        $conn->close();
        echo "Bad GET Value";
        die();
    }
    $sql->execute();
    $result = $sql->get_result();
}
else {
    $sql = "SELECT blendID, blendName, price, caffeination, visible, active FROM coffeeBlends WHERE visible = 1 AND active = 1";
    $result = $conn->query($sql);
}
if ($result!=NULL) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $caf = $row['caffeination']==0 ? 'Decaf' : 'Regular';
            echo "<tr>
                <td class='first'><a href='?view_product=" . $row['blendID'] . "'>" . $row['blendName'] . "</a></td>
                <td>&#36;{$row['price']}</td>
                <td>$caf</td>
            </tr>";
        }
    }
    else {
        echo '<tr><td class="first red">No products found</td><td/><td/></tr>';
    }
    $result->close();

}
echo "</table>";
$conn->close();

return;
?>
