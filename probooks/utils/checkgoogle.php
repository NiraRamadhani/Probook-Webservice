<?php
    $name = $_POST['name'];
    $image = $_POST['image'];
    $email = $_POST['email'];
    $uname = $_POST['email'];
    $adr = "";
    $phone = "";
    $card = "";
    $pw = "";

    // Connect to database
    $conn = new mysqli('localhost', 'root', '', 'probooks');
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }

    //create query
    if (isset($name, $uname, $pw, $email, $adr, $phone, $card)) {
        // TAMBAHIN DISINI
        $query = "INSERT INTO user VALUES('$uname', '$pw', '$name', '$phone', '$adr', '$email', '$image', '$card');";
        //execute query
        $insert = mysqli_query($conn, $query);

            $access_token = bin2hex(random_bytes(16));
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $expire = microtime(true) + 3600;
            
            $insert_session_query = "INSERT INTO probooks.session (session_id, username, browser, ip_adress, expire_time) VALUES ('$access_token', '$uname', '$browser', '$ip', '$expire')";
            $session = mysqli_query($conn, $insert_session_query);
            // echo "Sign in success";
            setcookie('username', $uname, time() + 600, '/');
            setcookie('access_token', $access_token, time() + 600, '/');
    }
        
    $conn->close();
?>