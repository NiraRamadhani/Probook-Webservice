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
    
    //get data from form
    $name = $_POST['name'];
    $uname = $_POST['username'];
    $pw = $_POST['password'];
    $email = $_POST['email'];
    $adr = $_POST['address'];
    $phone = $_POST['phone'];
    $card = $_POST['cardnumber'];

    //create query
    if (isset($name, $uname, $pw, $email, $adr, $phone, $card)) {
        // TAMBAHIN DISINI
        $query = "INSERT INTO user VALUES('$uname', '$pw', '$name', '$phone', '$adr', '$email', 'public/img/profpic/default.jpg', '$card');";
        //execute query
        if ($conn->query($query) === TRUE) {
            $access_token = bin2hex(random_bytes(16));
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $expire = microtime(true) + 3600;
            
            $insert_session_query = "INSERT INTO probooks.session (session_id, username, browser, ip_adress, expire_time) VALUES ('$access_token', '$uname', '$browser', '$ip', '$expire')";
            $session = mysqli_query($conn, $insert_session_query);
            
            setcookie('username', $uname, time() + 600, '/');
            setcookie('access_token', $access_token, time() + 600, '/');
            header('Location: ../search.php');
        }
    }
        
    $conn->close();
?>