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

    if (isset($_POST['username'])) {
        $uname = $_POST['username'];

        $checkdata = " SELECT username FROM user WHERE username='$uname' ";

        $query = mysqli_query($conn, $checkdata);

        if ($uname !== "") {
            if (mysqli_num_rows($query) > 0) {
                echo "<img id=unamestatus src='public/icons/mark.png' width=15px height=15px>";
            } else {
                echo "<img id=unamestatus src='public/icons/checked.png' width=15px height=15px>";
            }
        } else {
            echo "";
        }
        exit();
    }

?>