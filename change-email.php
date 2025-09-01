<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: /login.php");
    }
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $csrf_token = $_SESSION['csrf'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "portswigger-db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['email']) && isset($_POST['csrf'])){
        if($_POST['csrf'] == $csrf_token){
            $sql = "SELECT username, email FROM users WHERE username='" . $_SESSION['username'] . "' AND email='" . $_SESSION['email'] . "'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $sql = "SELECT * FROM users WHERE username !='" . $_SESSION['username'] . "' AND email='" . $_POST['email'] . "'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $_SESSION['error_message'] = "Email is not available.";
                    $_SESSION['success_message'] = "";
                    header("Location: /my-account.php");
                }else {
                    $sql = "UPDATE `" . $dbname . "`.`users` SET `email`='" . $_POST['email'] . "' WHERE  `username`='" . $_SESSION['username'] . "' AND `email`='" . $_SESSION['email'] . "' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result) {
                        $_SESSION['email'] = $_POST['email'];
                        $_SESSION['success_message'] = "Email changed successfully.";
                        $_SESSION['error_message'] = "";
                        header("Location: /my-account.php");
                    }
                }
            }else {
                session_destroy();
                $_SESSION['error_message'] = "Something went wrong. Please login again.";
                header("Location: /login.php");
            }
        }else {
            $_SESSION['error_message'] = "Wrong csrf token.";
            $_SESSION['success_message'] = "";
            header("Location: /my-account.php");
        }
    }
?>