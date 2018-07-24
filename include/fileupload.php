<?php
if (isset($_SESSION['loggedIn'])) {
    if (isset($_POST['upload'])) {
        if (isset($_FILES['file'])) {
            $allowed = ['image/pjpeg', 'image/'
                .'jpeg', 'image/jpg', 'image/png',
                'image/x-png'];
            $fileinfo = new finfo(FILEINFO_MIME_TYPE);
            if (in_array(strtolower($fileinfo->file($_FILES['file']['tmp_name'])), $allowed)) {
                if (file_exists($_FILES['file']['tmp_name']))
                {
                    require ('connect.php');
                    $stmt = $conn->stmt_init();
                    $stmt->prepare('SELECT pictureID from pictures, users WHERE userName = ? and pictures.userID = users.userID');
                    $stmt->bind_param('s', $_SESSION['loggedIn']);
                    $stmt->execute();
                    $rs = $stmt->get_result();
                    $row = $rs->fetch_assoc();
                    $stmt = $conn->stmt_init();
                    $null = NULL;
                    $image = file_get_contents($_FILES['file']['tmp_name']);
                    if ($row['pictureID']) {
                        $stmt->prepare("UPDATE users, pictures SET picture = ?, pictureType = ? WHERE users.userID = pictures.userID AND userName = ?");
                        $stmt->bind_param("bss", $null, $_FILES['file']['type'], $_SESSION['loggedIn']);
                        $stmt->send_long_data(0, $image);
                    }
                    else {
                        $stmt->prepare("INSERT INTO pictures (userID, picture, pictureType) VALUES ((SELECT userID FROM users WHERE userName=?), ?, ?)");
                        $stmt->bind_param("sbs",  $_SESSION['loggedIn'], $null, $_FILES['file']['type']);
                        $stmt->send_long_data(1, $image);
                    }
                    if (!$stmt->execute()) {
                        echo $stmt->error;
                    }
                }
            }
            else {
                echo '<p>Please upload a valid JPEG or PNG image</p>';
                //echo $_FILES['file']['type'];
            }
        }
        if ($_FILES['file']['error']> 0) {
            echo '<p>The file could not be uploaded because: <strong>';
            switch ($_FILES['file']['error']) {
                case 1:
                    print 'The file exceeds the upload_max_filesize setting in php.ini.';
                    break;
                case 2:
                    print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                    break;
                case 3:
                    print 'The file was only partially uploaded.';
                    break;
                case 4:
                    print 'No file was uploaded.';
                    break;
                case 6:
                    print 'No temporary folder was available.';
                    break;
                case 7:
                    print 'Unable to write to the disk';
                    break;
                case 8:
                    print 'File upload stopped';
                    break;
                default:
                    print 'A system error occurred';
                    break;
            }
            echo '</strong></p>';
        }
    }
}