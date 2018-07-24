<?php

require('connect.php');

function login(&$conn, $user, $password)
{
    $sql = $conn->stmt_init();
    $sql->prepare("SELECT userName FROM users WHERE userName IN (?)");
    $sql->bind_param('s', $user);
    $sql->execute();
    $accounts = $sql->get_result();
    if ($accounts!=NULL) {
        if ($accounts->num_rows > 0) {
            if ($user == $accounts->fetch_assoc()['userName']) {
                $sql = $conn->stmt_init();
                $sql->prepare("SELECT userPassword FROM users WHERE userName IN (?)");
                $sql->bind_param('s', $user);
                $sql->execute();
                $pass = $sql->get_result();
                if ($pass != NULL) {
                    if ($pass->num_rows > 0) {
                        if (password_verify($password, $pass->fetch_assoc()['userPassword'])) {
                            $_SESSION['loggedIn'] = $user;
                            $conn->close();
                            header("Location: ./store.php");
                            exit;
                        }
                    }
                }
            }
        }
    }
    echo "<h3 class='red'>Incorrect Username or Password</h3>";
    $conn->close();
}
