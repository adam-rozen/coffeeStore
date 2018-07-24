<?php

session_start();
include('./include/header1.php');

if (isset($_SESSION['loggedIn'])) {
    if ($_SESSION['loggedIn']) {
        if (isset($_POST['change'])) {
            require('./include/connect.php');
            $stmt = $conn->stmt_init();
            $stmt->prepare('SELECT userPassword FROM users WHERE userName IN (?)');
            $stmt->bind_param('s', $_SESSION['loggedIn']);
            $stmt->execute();
            $result = $stmt->get_result();
            $result = $result->fetch_assoc();
            if (password_verify($_POST['old'], $result['userPassword'])) {
                if ($_POST['new']==$_POST['confirm']) {
                    $pass = password_hash($_POST['new'], PASSWORD_BCRYPT);
                    $stmt = $conn->stmt_init();
                    $stmt->prepare('UPDATE users SET userPassword = ? WHERE userName = ?');
                    $stmt->bind_param('ss', $pass, $_SESSION['loggedIn']);
                    $stmt->execute();
                    echo "Password Changed!";
                    $conn->close();
                }
                else {
                    echo "Please try again<br>";
                }
            }
            else {
                echo "Please try again<br>";
            }
        }
        elseif (isset($_POST['upload'])) {
            include 'include/fileupload.php';
        }
?>

<p>Username: <?=$_SESSION['loggedIn']?></p>
<form action="" method="post">
    <fieldset>
        <legend>Change Password</legend>
        <input type="password" name="old" placeholder="Old Password" value="">
        <input type="password" name="new" placeholder="New Password" value="">
        <input type="password" name="confirm" placeholder="Confirm New Password" value="">
        <input type="submit" name="change" value="Change Password">
    </fieldset>
</form>
<br>
<br>
<form enctype="multipart/form-data" action="" method="post">
    <fieldset>
        <legend>Upload Profile Picture</legend>
        <span>JPG and PNG files only</span>
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
        <input type="file" accept="image/jpeg, image/x-png" name="file" required>
        <input type="submit" name="upload" value="Upload Picture">
    </fieldset>
</form>
<br>
<br>

<a href="./include/logoutUser.php">Logout</a>

<?php
include('./include/footer.php');
exit;
}
}
?>

<h3 class='red'>You do not have permission to view this page, please login first!</h3>
<?php include('./include/footer.php') ?>
