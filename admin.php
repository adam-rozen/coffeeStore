<?php
/**
 * File:		admin.php
 * Author:		Adam Rozen
 * Purpose:	    Admin stuff
 **/
session_start();

include("./include/header1.php");
require("./include/connect.php");

if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin']==true) {
        $products = $conn->query('SELECT blendName, price, caffeination, active, blendID, coffeeDescription, visible FROM coffeeBlends');

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            if (isset($_POST['delete_products'])) {
                $pro = $products->num_rows;
                $delete = [];
                $q = 'UPDATE coffeeBlends SET active=0, visible=0 WHERE blendID IN (';
                $w = '';

                for ($i = 1; $i <= $pro; $i++) {
                    if(isset($_POST["box$i"])) {
                        array_push($delete,  $i);
                        $q .= '?, ';
                        $w .= 'i';
                    }
                }
                $sql = $conn->stmt_init();
                
                $q = substr($q, 0, -2);
                $q.=')';
                echo $q;
                echo $w;
                var_dump($delete);
                $sql->prepare($q);
                $sql->bind_param($w, ...$delete);
                $sql->execute();
                header('Location: ./admin.php');

            } elseif (isset($_POST['add_to_products'])) {
                $a=(isset($_POST['caffeination']) ? 0 : 1);
                $b=(isset($_POST['vis']) ? 1 : 0);
                $sql = $conn->stmt_init();
                $sql->prepare("INSERT INTO coffeeBlends (blendName, price,
                    caffeination, coffeeDescription, visible) VALUES (?, ?, ?, ?, ?)");
                $sql->bind_param('sdisi', $_POST['name'], $_POST['price'],
                    $a, $_POST['description'], $b);
                $sql->execute();
                header('Location: ./admin.php');
            }
        }

        ?>
            <a style='text-align: center;' href='./include/logoutAdmin.php'>Admin Logout</a>
            <table style='width:750px' cellspacing='0'>
            <form action='./admin.php' method='post'>
            <tr style='border-bottom:1px solid #000000;'>
                <th style='border-bottom:1px solid #000000;'>Delete</th>
                <th style='border-bottom:1px solid #000000;'>Name</th>
                <th style='border-bottom:1px solid #000000;'>Price</th>
                <th style='border-bottom:1px solid #000000;'>Caffeination</th>
                <th style='border-bottom:1px solid #000000;'>Visible</th>
                <th style='border-bottom:1px solid #000000;'>Description</th>
            </tr>
        <?php

        if ($products!=NULL) {
            if ($products->num_rows > 0) {
                while ($row = $products->fetch_assoc()) {
                    if ($row['active']) {
                        $caf = $row['caffeination'] == 0 ? 'Decaf' : 'Regular';
                        echo "<tr>
                        <td><input type='checkbox' name='box{$row['blendID']}' value='delete{$row['blendID']}'/></td>
                        <td style='font-weight:bold;border-bottom:1px solid #000000;'><a href='./store.php?view_product={$row['blendID']}'>{$row['blendName']}</a></td>
                        <td style='border-bottom:1px solid #000000;'>&#36;{$row['price']}</td>
                        <td style='text-align:center;border-bottom:1px solid #000000;'>$caf</td>
                        <td style='text-align:center;border-bottom:1px solid #000000;'><input type='checkbox'";
                        if ($row['visible']==1)
                        {
                            echo "checked='checked'";
                        }
                        echo "name='vis' onclick='return false;' /></td>
                        <td style='border-bottom:1px solid #000000;'>{$row['coffeeDescription']}</td>
                        <td><input type='submit' formaction='edit.php?edit={$row['blendID']}' name='{$row['blendID']}' value='Edit'></td>
                        </tr>";
                    }
                }
            }
        }

        ?><tr><td><input type='submit' name='delete_products' value='Delete'/></td></form>
            <form action='./admin.php' method='post'>
            <td />
            <td />
            <td />
            <td />
            <td />
            </tr><tr>
            <td />
            <td style='border-bottom: 1px solid #000000;'><input type='text' name='name' value='' required='true' style='width:125px;'/></td>
            <td style='border-bottom:1px solid #000000;'><input type='number' name='price' step='.01' required='true' min='0' value='0' style='width:45px;'/></td>
            <td style='border-bottom:1px solid #000000;width:100px;'><input type='checkbox' name='decaf' value='decaf'/>Decaf</td>
            <td style='border-bottom:1px solid #000000;width:100px;'><input type='checkbox' name='vis' checked='checked' value='vis'/>Visible</td>
            <td style='border-bottom:1px solid #000000;'><input type='text' name='description' required='true' value=''/></td>
            <td><input type='submit' name='add_to_products' value='Add'/></td></tr></table>
            </form>
        <?php
        include("./include/footer.php");
        exit;
    }
}

echo "<h3 class='red'>You do not have permission to view this page, please login first!</h3>";

include("./include/footer.php");

?>
