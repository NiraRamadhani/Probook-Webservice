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

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $checkdata = " SELECT email FROM user WHERE email='$email' ";

        $query = mysqli_query($conn, $checkdata);

        if ($email !== "") {
            if (mysqli_num_rows($query) > 0) {
                echo "<img id=emailstatus src='public/icons/mark.png' width=15px height=15px>";
            } else {
                echo "<img id=emailstatus src='public/icons/checked.png' width=15px height=15px>";
            }
        } else {
            echo "";
        }
        exit();
    }

?>