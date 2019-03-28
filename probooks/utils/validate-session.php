<?php 
    function validate($access_token, $username, $action) {
        // Get current session data
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $expire = microtime(true);

        $con = mysqli_connect("localhost","root","","probooks");
        
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "SELECT * FROM session WHERE session_id='$access_token'";
        $execute = mysqli_query($con, $sql);
        
        if ($execute) {
            $result = $execute->fetch_assoc(); 
            
            // Get session data from database
            $session_db = $result['session_id'];
            $username_db = $result['username'];
            $browser_db = $result['browser'];
            $ip_db = $result['ip_adress'];
            $expire_db = $result['expire_time'];

            //Validation
            if (($session_db === $access_token) and ($username_db === $username) and ($browser_db === $browser)
                and ($ip_db === $ip)) {
                if ($expire < $expire_db) {
                    if (isset($action)) {
                        header("Location: $action");
                    }
                } else {
                    header('Location: ../logout.php');
                }
                // do nothing
            } else {
                deleteCookies();  
                header('Location: ../login.php');
                exit();
            }
        } else {
            echo "session not found";
        } 
    }

    function test($angka) {
        echo($angka*2);
    }

    function checkSession() {
        $con = mysqli_connect("localhost","root","","probooks");

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $now = microtime(true);
        // echo($now . "<br>");
        $retrieve = "SELECT * FROM session WHERE expire_time < $now";
        $result = mysqli_query($con, $retrieve);
        while ($row = $result->fetch_assoc()) {
            // echo ($row['session_id'] . "<br>");
            deleteSession($con, $row['session_id']);
        }
    }

    function deleteSession($con, $access_token) {
        // Called after connecting to Probooks database
        $del = "DELETE FROM `session` WHERE (`session_id` = '$access_token')";
        $delete = mysqli_query($con, $del);
        if (!$delete) {
        //     header('Location: ../login.php');
        //     exit();
        // } else {
            echo "session delete error";
        }
    }

    function deleteCookies() {
        unset($_COOKIE['username']);
        setcookie('username', '', time() - 3600, '/'); // empty value and old timestamp
        unset($_COOKIE['access_token']);
        setcookie('access_token', '', time() - 3600, '/'); // empty value and old timestamp
    }
?>