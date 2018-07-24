<?php

include 'connect.php';

session_start();

$stmt = $conn->stmt_init();
$stmt->prepare('SELECT picture, pictureType FROM pictures, users WHERE users.userName = ? AND users.userID = pictures.userID');
$stmt->bind_param('s', $_SESSION['loggedIn']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$conn->close();
if ($row['picture']) {
    header("Content-type: {$row['pictureType']}");
    echo $row['picture'];
}
else {
    header("Content-type: image/X-PNG");
    include 'blank_profile_picture.png';
}
?>
