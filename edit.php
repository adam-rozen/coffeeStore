<?php
/**
 * File:		edit.php
 * Author:		Adam Rozen
 * Purpose:		Edit one product
 **/

session_start();

include_once 'include/header1.php';

if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin']==true) {

        require_once 'include/connect.php';

        if (isset($_POST['edit'])) {
            $sql = $conn->stmt_init();
            $sql->prepare('UPDATE coffeeBlends SET blendName = ?, price = ?, coffeeDescription = ?, visible = ?, caffeination = ? WHERE blendID = ?');
            $a=(isset($_POST['decaf']) ? 0 : 1);
            $b=(isset($_POST['vis']) ? 1 : 0);
            $sql->bind_param('sdsiii', $_POST['blendName'], $_POST['price'], $_POST['description'], $b, $a, $_POST['blendID']);
            $sql->execute();
            header('Location: ./admin.php');
        }

        $product_id = $_GET['edit'];
        $stmt = $conn->stmt_init();
        if ($stmt->prepare("SELECT * FROM coffeeBlends WHERE blendID = ?")) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();

                $page = $row['caffeination'] == "0" ? "Decaf" : "Regular";

                ?>

                <form action='edit.php' method='post'>
                    <label for="blendName">Name: </label>
                    <input type='text' name='blendName' required value='<?=$row['blendName']?>' />
                    <br>
                    <label for="price">Price: </label>
                    <input type='number' name='price' step='.01' required='true' min='0' value='<?=$row['price']?>' />
                    <br>
                    <label for="decaf">Decaf: </label>
                    <input type='checkbox' name='decaf' value='decaf' <?=($row['caffeination'])=='0' ? 'checked' : ''?> />
                    <br>
                    <label for="vis">Visible: </label>
                    <input type='checkbox' name='vis' value='vis' <?=($row['visible'])=='1' ? 'checked' : ''?> />
                    <br>
                    <label for="description">Description: </label>
                    <input type='text' name='description' required='true' value='<?=$row['coffeeDescription']?>'/>
                    <br>
                    <input type='hidden' name='blendID' value='<?=$product_id?>' />
                    <input type='submit' name='edit' value='Submit Changes' />
                </form>
            <?php
            }
            else {
                echo "Invalid product!";
            }
            $result->close();
        }
        $conn->close();
        include("./include/footer.php");
        exit;
    }
}

echo "<h3 class='red'>You do not have permission to view this page, please login first!</h3>";

include("./include/footer.php");

?>
