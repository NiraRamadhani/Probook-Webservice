<?php
require_once 'utils/validate-session.php';

// check whether user is already logged in or not
$username = $_COOKIE['username'];
$access_token = $_COOKIE['access_token'];

$config = include 'config/db.php';
$conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['db_name']);
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

validate($access_token, $username, null);
checkSession($conn);

setcookie('access_token', $access_token, time() + 600, '/');
setcookie('username', $username, time() + 600, '/');
 

    $order = $_POST['orderId'];
    $book = $_POST['bookId'];

    if (isset($order, $book)) {
       //do nothing
    } else {
        //redirect to search-books page
        header('Location: history.php');
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Review Page</title>
        <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
        <link rel="stylesheet" type="text/css" href="public/css/body.css">
        <link rel="stylesheet" type="text/css" href="public/css/review.css">
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
                <li><a class="active text-white" href="history.php">History</a></li>
                <li><a class="text-white" href="profile.php">Profile</a></li>
            </ul>
        </div>
    </head>
    <body>
        <div class="book-container">
            <?php 
                // CALL SOAP API
                $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl");
                $params = array(
                    "arg0" => $book
                );
                $response = $client->__soapCall("getDetail", $params);
                $detail = json_encode($response);
                $detail = json_decode($detail, true);
                echo"<img class='book-img' src='{$detail['gambar']}'>
                <div class='book-title'>{$detail['judul']} </div>
                <div class='book-author'>{$detail['penulis']}</div>";
            ?>
        </div>
        
        <form action="/utils/review-process.php" method="POST" name="review" onsubmit="return validateForm()">
        <div class="rating-container">
            <div class="subtitle"> Add Rating </div>
            <div class="rating">
                <img id="star0" key="0" src="public/img/star-inactive.png">
                <img id="star1" key="1" src="public/img/star-inactive.png">
                <img id="star2" key="2" src="public/img/star-inactive.png">
                <img id="star3" key="3" src="public/img/star-inactive.png">
                <img id="star4" key="4" src="public/img/star-inactive.png">
            </div>
        </div>

        <div class="comment-container">
            <div class="subtitle"> Add Comment </div>
            <textarea name="comment"></textarea> <br>
            <input type="hidden" id="rating1" name="rating" value="0">
            <input type="hidden" id="order-id" name="orderId" value="<?php echo $order;?>">
            <input type="submit" class="submit" name="submit_btn">  
            <input type="button" class="back" value="Back" onclick="history.back()">
        </div>
        </form>
    </body>
</html>

<script src="public/js/review.js"></script>