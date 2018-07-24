<?php

if (isset($_POST['reg']))
{
    $stmt = $conn->stmt_init();
    $stmt->prepare('SELECT userID FROM users WHERE emailAddress=?');
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $results = $stmt->get_result();
    if ($results!=NULL)
    {
        if ($results->num_rows==0)
        {
            $stmt = $conn->stmt_init();
            $stmt->prepare('SELECT userID FROM users WHERE userName=?');
            $stmt->bind_param('s', $_POST['user']);
            $stmt->execute();
            $results = $stmt->get_result();
            if ($results!=NULL)
            {
                if ($results->num_rows==0)
                {
                    $stmt = $conn->stmt_init();
                    $stmt->prepare('INSERT INTO users (userName, userPassword,
                        emailAddress) VALUES(? ,?, ?)');
                    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
                    $stmt->bind_param("sss", $_POST['user'],
                        $pass, $_POST['email']);
                    $stmt->execute();
                    login($conn, $_POST['user'], $_POST['pass']);
                }
                else {
                    echo 'There is already an account associated with that userName.';
                }
            }
        }
        else {
            echo 'There is already an account associated with that email.';
        }
    }


}

?>
