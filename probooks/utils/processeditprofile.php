<?php
    //connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "probooks";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //get user data from cookie
    $uname = $_COOKIE['username'];

    //get data from form
    $name = $_POST['name'];
    $adr = $_POST['address'];
    $phone = $_POST['phone'];
    $filename = $_FILES['photoaddress']['name'];
    $filepath = "public/img/profpic/" . $filename;
    $file_tmp = $_FILES['photoaddress']['tmp_name'];
    $card = $_POST['cardnumber'];
    //create query
    if ($filename !== "") {
        $query = "UPDATE user SET name = '$name', address = '$adr', phone = '$phone', image = '$filepath' WHERE, cardnumber = '$card' username = '$uname'";
    } else {
        $query = "UPDATE user SET name = '$name', address = '$adr', phone = '$phone', cardnumber = '$card' WHERE username = '$uname'";
    }
    //execute query
    if ($conn->query($query) === TRUE) {
        
        //move file to storage
        move_uploaded_file($file_tmp, "../public/img/profpic/".$filename);
    
        header('Location: ../profile.php');
    }
    $conn->close();
?>