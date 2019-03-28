<?php
    require_once 'utils/validate-session.php';    

    $username = $_COOKIE['username'];
    $access_token = $_COOKIE['access_token'];

    // Connect to database
    $con = mysqli_connect("localhost","root","","probooks");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($username) and isset($access_token)) {
        deleteCookies();
        deleteSession($con, $access_token);           
    }
    header('Location: login.php');
?>