<?php
    require_once 'utils/validate-session.php';

    // Get data from cookie
    $username = $_COOKIE['username'];
    $access_token = $_COOKIE['access_token'];
    
    if(isset($username) && (isset($access_token))) {
        validate($access_token, $username, 'search.php');
        setcookie('access_token', $access_token, time() + 600, '/');
        setcookie('username', $username, time() + 600, '/');
    }

    checkSession();

    
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>Register page</title>
            <link rel="stylesheet" type="text/css" href="public/css/login.css">
            <link rel="stylesheet" type="text/css" href="public/css/body.css">
        </head>

        <body>
            <div class="content-register">
            <center><h2>REGISTER</h2></center>
            <form name="register" action="utils/process-register.php" method="post" onsubmit="return validateRegistrationForm()">
                <center><table>
                    <tr>
                        <td>Name</td>
                        <td colspan=2><input type="text" class="nonajax" name="name"></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><input type="text" name="username" class="ajax" onkeyup="checkname();"></td>
                        <td id="username_status"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="email" class="ajax" onkeyup="checkemail();"></td>
                        <td id="email_status"></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td colspan=2><input type="password" class="nonajax" name="password"></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td colspan=2><input type="password" class="nonajax" name="cpassword"></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td colspan=2><textarea name="address"></textarea></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td colspan=2><input type="text" class="nonajax" name="phone"></td>
                    </tr>
                    <tr>
                        <td>Card Number</td>
                        <td><input type="text" name="cardnumber" class="ajax" onkeyup="checkcard();"></td>
                        <td id="card_status"></td>
                    </tr>
                </table></center>
                <br>
                <a href="login.php">Already have an account?</a>
                <br><br>
                <center><input type="submit" value="REGISTER"></center>
            </form>
            </div>
            <div class="square"></div>
        </body>

        <script type="text/javascript">
            function validateRegistrationForm() {
                //get data from the form
                var name = document.forms["register"]["name"].value;
                var uname = document.forms["register"]["username"].value;
                var email = document.forms["register"]["email"].value;
                var pw = document.forms["register"]["password"].value;
                var cpw = document.forms["register"]["cpassword"].value;
                var address = document.forms["register"]["address"].value;
                var phone = document.forms["register"]["phone"].value;
                var cardnumber = document.forms["register"]["cardnumber"].value;
                if (name == "") { //Name field empty
                    alert("Name must be filled out");
                    return false;
                }
                if (uname == "") { //Username field empty
                    alert("Username must be filled out");
                    return false;
                }
                if (email == "") { //Email field empty
                    alert("Email must be filled out");
                    return false;
                }
                if (pw == "") { //Password field empty
                    alert("Password must be filled out");
                    return false;
                }
                if (cpw == "") { //Confirm Password field empty
                    alert("Password must be confirmed");
                    return false;
                }
                if (address == "") { //Address field empty
                    alert("Address must be filled out");
                    return false;
                }
                if (phone == "") { //Phone Number field empty
                    alert("Phone Number must be filled out");
                    return false;
                }
                if (pw !== cpw) { //Entered password does not match confirmed password
                    alert("Confirmed password does not match");
                    return false;
                }
                if (name.length > 20) { //Name length more than 20 characters
                    alert("Name must not be longer than 20 characters");
                    return false;
                }
                if (phone.length > 12 || phone.length < 9) { //Phone Number length less than 9 or more than 12 characters
                    alert("Phone Number must be 9 to 12 characters");
                    return false;
                }
                if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))) { //Email format invalid
                    alert("Email is invalid");
                    return false;
                }
                if (cardnumber == "") { //Email field empty
                    alert("Card number must be filled out");
                    return false;
                }
                
                var namehtml = document.getElementById("unamestatus").getAttribute("src");
                var emailhtml = document.getElementById("emailstatus").getAttribute("src");
                var cardhtml = document.getElementById("cardstatus").getAttribute("src");
                if (namehtml == "public/icons/mark.png") {
                    alert("Username already exists");
                    return false;
                }
                if (emailhtml == "public/icons/mark.png") {
                    alert("Email already exists");
                    return false;
                }
                if (cardhtml == "public/icons/mark.png") {
                    alert("Card number doesn't exists");
                    return false;
                }
            }

            function checkname() {
                var username = document.forms["register"]["username"].value;
                var xmlHttp = new XMLHttpRequest();
                var url="utils/checkusername.php";
                var param = "username=" + username;
                xmlHttp.open("POST", url, true);

                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttp.setRequestHeader("Content-length", param.length);
                xmlHttp.setRequestHeader("Connection", "close");
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        document.getElementById('username_status').innerHTML = xmlHttp.responseText;
                    }
                }
                xmlHttp.send(param);
            }

            function checkemail() {
                var email = document.forms["register"]["email"].value;
                var xmlHttp = new XMLHttpRequest();
                var url="utils/checkemail.php";
                var param = "email=" + email;
                xmlHttp.open("POST", url, true);

                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHttp.setRequestHeader("Content-length", param.length);
                xmlHttp.setRequestHeader("Connection", "close");
                xmlHttp.onreadystatechange = function() {
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        document.getElementById('email_status').innerHTML = xmlHttp.responseText;
                    }
                }
                xmlHttp.send(param);
            }

            function checkcard() {
                var cardnumber = document.forms["register"]["cardnumber"].value;
                var xmlHttp = new XMLHttpRequest();
                var url="http://localhost:3000/validasi";
                var param = "cardnumber=" + cardnumber;
                xmlHttp.open("POST", url, true);

                xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                // xmlHttp.setRequestHeader("Content-length", param.length);
                // xmlHttp.setRequestHeader("Host", "3000");
                // xmlHttp.setRequestHeader("Connection", "close");

                xmlHttp.onreadystatechange = function() {
                    console.log(xmlHttp.responseText);
                    console.log(xmlHttp.status);                    
                    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                        console.log(xmlHttp);
                        document.getElementById('card_status').innerHTML = (xmlHttp.responseText);
                    }
                }
                xmlHttp.send(param);
            }

            window.onload = function() {
                checkname();
                checkemail();
                checkcard();
            }

        </script>
    </html>