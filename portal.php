<?php
session_start();
include './include/header1.php';
if (isset($_SESSION['admin'])) {
    header('Location: ./admin.php');
}
?>
<div style='width:25%;float:left;'>
    <form action='./include/login_admin.php' method='post'>
        <p>Username: <input type="text" name='user' value='' required/></p>
        <p>Password: <input type="password" name='pass' value='' required/></p>
        <p style='text-align:center;'><input type='submit' name='login' value='Login' /></p>
    </form>
</div>

<?php
include './include/footer.php';
?>