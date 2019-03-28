<?php

// check whether user is already logged in or not
$username = $_COOKIE['username'];

if (isset($username)) {    
    //connect to database
    header('Location: search.php');
} else {
    //redirect to login page
    header('Location: login.php');
}
?>