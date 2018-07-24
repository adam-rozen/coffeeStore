            <br>
            <br>
            <?php if (substr($_SERVER['SCRIPT_NAME'], -9) != 'admin.php' and substr($_SERVER['SCRIPT_NAME'], -10) != 'portal.php'): ?>
            <a href="./portal.php">Admin <?=(isset($_SESSION['admin']) and $_SESSION['admin']==true) ? 'Portal' : 'Login'?></a>
            <?php endif?>
        </div><!-- End content-->
    </div><!-- End container-->
</body>
</html>