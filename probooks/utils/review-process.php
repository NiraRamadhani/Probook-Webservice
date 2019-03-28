<?php
// check whether user is already logged in or not
// $config = include '/config/db.php';
$username = $_COOKIE['username'];

if (isset($username)) {    
    $config = include '../config/db.php';
    $conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['db_name']);
        if (!$conn) {
            die("Connection failed: " . $conn->connect_error);
        }
    
    //Get Data from POST
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $order = $_POST['orderId'];

    if (isset($order, $rating, $comment)){
        $query = "INSERT INTO review (orderid, content, rating) 
                    VALUES('$order', '$comment', '$rating')";
        //execute query
        if ($conn->query($query) === TRUE) {
            header('Location: ../history.php');
        } else {
            echo"gabisa";
        }
    } else {
        header('Location: ../history.php');
    }
} else {
    //redirect to login page
    header('Location: ../login.php');
}
?>