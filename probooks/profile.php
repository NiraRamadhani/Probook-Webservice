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
    $sql = "SELECT username, name, address, phone, email, image, cardnumber FROM user WHERE username = '$uname'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $uname = $row["username"];
    $name = $row["name"];
    $address = $row["address"];
    $phone = $row["phone"];
    $email = $row["email"];
    $photo = $row["image"];
    $cardnumber = $row["cardnumber"];

    mysqli_close($conn);
?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Your Profile</title>
            <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
            <link rel="stylesheet" type="text/css" href="public/css/body.css">
            <link rel="stylesheet" type="text/css" href="public/css/profile.css">
        </head>
        <body>
            <div id="nav">
                <ul>
                    <li id="li-pro-book"><a href="search.php" id="pro-book">
                        <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
                    </a></li>
                    <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo $_COOKIE['username']; ?></a></li>
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
            <div class="profile-header">
                <center><img class="profpic" src="<?php echo $photo; ?>"></center>
                <center><h1 class="name"><?php echo "$name"; ?></h1></center>
                <a href="editprofile.php"><img class="edit" src="public/icons/edit.png"></a>
            </div>
            <div class="profile-content">
            <h1 class="title">My Profile</h1>
            <table>
                <tr>
                    <td><img src="public/icons/user.png" width=20px height=20px></td>
                    <td>Username</td>
                    <td class="content">@<?php echo "$uname"; ?></td>
                </tr>
                <tr>
                    <td><img src="public/icons/email.png" width=20px height=20px></td>
                    <td>Email</td>
                    <td class="content"><?php echo "$email"; ?></td>
                </tr>
                <tr>
                    <td><img src="public/icons/address.png" width=20px height=20px></td>
                    <td>Address</td>
                    <td class="content"><?php echo "$address"; ?></td>
                </tr>
                <tr>
                    <td><img src="public/icons/phone.png" width=20px height=20px></td>
                    <td>Phone Number</td>
                    <td class="content"><?php echo "$phone"; ?></td>
                </tr>
                <tr>
                    <td><img src="public/icons/card.png" width=20px height=20px></td>
                    <td>Card Number</td>
                    <td class="content"><?php echo "$cardnumber"; ?></td>
                </tr>
            </table>
        </div>
        </body>
    </html>