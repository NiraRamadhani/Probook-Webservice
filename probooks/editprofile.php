<?php
    require_once 'utils/validate-session.php';

    //get user data from cookie
    $uname = $_COOKIE['username'];
    $access_token = $_COOKIE['access_token'];

    validate($access_token, $uname, null);
    checkSession();

    setcookie('access_token', $access_token, time() + 600, '/');
    setcookie('username', $uname, time() + 600, '/');

    //connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "probooks";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }

    //fetch data from db
    $sql = "SELECT name, address, phone, image, cardnumber FROM user WHERE username = '$uname'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row["name"];
    $address = $row["address"];
    $phone = $row["phone"];
    $photo = $row["image"];
    $cardnumber = $row["cardnumber"];

    mysqli_close($conn);
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Edit your profile</title>
            <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
            <link rel="stylesheet" type="text/css" href="public/css/body.css">
            <link rel="stylesheet" type="text/css" href="public/css/editprofile.css">
        </head>
        <body>
            <div id="nav">
                <ul>
                    <li id="li-pro-book"><a href="search.php" id="pro-book">
                        <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
                    </a></li>
                    <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo $_COOKIE['username'];?></a></li>
                    <li id="li-logout"><a href="logout.php" id="logout" class="text-white">
                        <img src="public/img/power.png" alt="Logout" height="30" width="30">
                    </a></li>
                </ul>
                <ul id="menu">
                    <li><a class="text-white" href="search.php">Browse</a></li>
                    <li><a class="text-white" href="history.php">History</a></li>
                    <li><a class="active text-white" href="profile.php">Profile</a></li>
                </ul>
            </div>
            <div class="content">
            <h1 class="title">Edit Profile</h1>
            <form name="edit" action="utils/processeditprofile.php" method="post" onsubmit="return validateEditForm()" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><img class="profpic" src="<?php echo $photo; ?>"></td>
                        <td>Update profile picture
                            <br>
                            <input class="file" type="text" id="filename">
                            <input type="file" id="file" name="photoaddress" class="custom-file-input" accept="image/*" onchange="javascript:displayFile()">
                        </td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><input class="notfile" type="text" name="name" value=<?php echo "'$name'"; ?>></td>
                    </tr>
                    <tr>
                        <td class="address-cell">Address</td>
                        <td><textarea name="address"><?php echo "$address"; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><input class="notfile" type="text" name="phone" value=<?php echo "$phone"; ?>></td>
                    </tr>
                    <tr>
                        <td>Card Number</td>
                        <td><input class="notfile card-col" type="text" name="cardnumber" onkeyup="checkcard();" value=<?php echo "$cardnumber"; ?>>
                        <a id="card_status"></a></td>
                    </tr>
                    <tr>
                        <td><input type="button" onclick="location.href='profile.php';" value="Back"></td>
                        <td class="submit"><input type="submit" value="Save"></td>
                    </tr>
                </table>
            </form>
        </div>
        </body>
        
        <script type="text/javascript">
            function validateEditForm() {
                var name = document.forms["edit"]["name"].value;
                var address = document.forms["edit"]["address"].value;
                var phone = document.forms["edit"]["phone"].value;
                var cardnumber = document.forms["edit"]["cardnumber"].value;
                if (name == "") {
                    alert("Name must be filled out");
                    return false;
                }
                if (address == "") {
                    alert("Address must be filled out");
                    return false;
                }
                if (phone == "") {
                    alert("Phone Number must be filled out");
                    return false;
                }
                if (name.length > 20) {
                    alert("Name must not be longer than 20 characters");
                    return false;
                }
                if (phone.length > 12 || phone.length < 9) {
                    alert("Phone Number must be 9 to 12 characters");
                    return false;
                }
                if (cardnumber == "") { 
                    alert("Card number must be filled out");
                    return false;
                }
                var cardhtml = document.getElementById("cardstatus").getAttribute("src");
                if (cardhtml == "public/icons/mark.png") {
                    alert("Card number doesn't exists");
                    return false;
                }
            }

            function checkcard() {
                var cardnumber = document.forms["edit"]["cardnumber"].value;
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
                checkcard();
            }

            displayFile = function() {
                var input = document.getElementById('file');
                var output = document.getElementById('filename');

                output.value = input.files.item(0).name;
            }
        </script>
    </html>
