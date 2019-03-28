<?php
    ob_start();
    require_once 'utils/validate-session.php';
    // require_once 'utils/Google/autoload.php';

    // if token ter validasi

    $con = mysqli_connect("localhost","root","","probooks");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    if (isset($_COOKIE['username']) and isset($_COOKIE['access_token'])) {
        validate($_COOKIE['access_token'], $_COOKIE['username'], 'search.php');
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        $get_username = mysqli_real_escape_string($con, $_POST['username']);
        $get_password = mysqli_real_escape_string($con, $_POST['password']);
        $sql="SELECT * FROM user WHERE username = '$get_username' AND password = '$get_password'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 1) {
            
            $access_token = bin2hex(random_bytes(16));
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $expire = microtime(true) + 3600;
            
            $insert_session_query = "INSERT INTO probooks.session (session_id, username, browser, ip_adress, expire_time) VALUES ('$access_token', '$get_username', '$browser', '$ip', '$expire')";
            $session = mysqli_query($con, $insert_session_query);
            
            setcookie('access_token', $access_token, time() + 600, '/');
            setcookie('username', $_POST['username'], time() + 600, '/');
            
            if ($session) {
                header('Location: search.php');
                exit();
            } else {
                echo("Insert gagal");
            }
            
            exit;
        } else {
            echo '<script>alert("Wrong username or password");</script>';
        }

    }
    $con->close();

    // // GOOGLE API SIGN IN
    // $client = new Google_Client();
    // $client->setApplicationName("Probooks");
    // $client->setDeveloperKey("AIzaSyAOyuL_JzI6t0sBkxksHvMu8Ed2g9HGmwI");
    // $client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
    // $client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

    // $oauthService = new Google_Service_Oauth2($client);
    // $userInfo = $oauthService->userinfo_v2_me->get();
    // echo "User info:<br>Name: ".$userInfo->name
    // ."<br>givenName: ".$userInfo->givenName
    // ."<br>familyName: ".$userInfo->familyName
    // ."<br>email: ".$userInfo->email;
    // $service = new Google_Service_Books($client);
  
    $sec = 1;
    $page = $_SERVER['PHP_SELF'];
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>LOGIN</title>
            <link rel="stylesheet" type="text/css" href="public/css/login.css">
            <link rel="stylesheet" type="text/css" href="public/css/body.css">
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <meta name="google-signin-client_id" content="534996295732-pg3de2vf8qceeb860hgscm3hk21438gj.apps.googleusercontent.com">
            
        </head>
        <body>
            <div class="content">
                <h2>LOGIN</h2>
                <form name="login" method="post" onsubmit="return validate()" action="">
                    <center>
                        <table>
                            <tr>
                                <td>Username</td>
                                <td><input type="text" name="username"></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><input type="password" name="password"></td>
                            </tr>
                        </table>
                    </center><br>
                    <center>
                    <div class="g-signin2" data-onsuccess="onSignIn"></div>
                    <br>
                        <a href="register.php">Don't have an account?</a><br><br>
                        <input type="submit" name="submit" value="LOGIN">
                    </center>
                </form>
            </div>
        </body>

        <script>
            function validate() {
                var uname = document.forms["login"]["username"].value;
                var pw = document.forms["login"]["password"].value;
                
                if (uname == "" || pw == "") { //field empty
                    alert("Fields must be filled out");
                    return false;
                }
            }
            function wrong() {
                alert("Wrong username or password");
            }

            function onSignIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
                
                var email = profile.getEmail();
                var image = profile.getImageUrl();
                var name = profile.getName();

                var xmlHttp = new XMLHttpRequest();
                var url="utils/checkgoogle.php";
                var param = "email=" + email + "&name=" + name + "&image=" + image;
                xmlHttp.open("POST", url, true);

                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        console.log(xmlHttp.responseText);
                        signOut();
                        window.location = "/search.php";
                    }
                }
                xmlHttp.send(param);
                
            }

            function signOut() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                console.log('User signed out.');
                });
            }
            
        </script>
    </html>

