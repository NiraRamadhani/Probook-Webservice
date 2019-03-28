<?php
    require_once 'utils/validate-session.php';    

    $username = $_COOKIE['username'];
    $access_token = $_COOKIE['access_token'];

    validate($access_token, $username, null);
    checkSession();
    
    setcookie('access_token', $access_token, time() + 600, '/');
    setcookie('username', $username, time() + 600, '/');

    // check if id = access_token + username
    // true: do task
    // false: redirect to login
    if (isset($_POST['bookid'])) {
        $bookid = $_POST['bookid'];            
    } else {
        $bookid = $_GET['bookid'];
    }
    
?>

<?php
  $servername = "localhost";
  $userdb = "root";
  $password = "";
  $dbname = "probooks";
  
  // Create connection
  $conn = new mysqli($servername, $userdb, $password, $dbname);
  $cardnumber;
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT cardnumber FROM user WHERE username='$username'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $cardnumber = $row["cardnumber"];
    }
    echo($row["cardnumber"]);
  } else {
    echo "0 results";
  }
  $conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book-Detail</title>
  <link rel="stylesheet" type="text/css" href="public/css/body.css">   
  <link rel="stylesheet" type="text/css" href="public/css/navbar.css">   
  <link rel="stylesheet" type="text/css" href="public/css/order.css">
  <link rel="stylesheet" type="text/css" href="public/css/search-books.css">
</head>
<body>
  <div id="nav">
    <ul>
      <li id="li-pro-book">
        <a href="search.php" id="pro-book">
          <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
        </a>
      </li>
      <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo $_COOKIE['username']; ?></a></li>
      <li id="li-logout">
        <a href="logout.php" id="logout" class="text-white">
          <img src="public/img/power.png" alt="Logout" height="30" width="30">
        </a>
      </li>
    </ul>
    <ul id="menu">
      <li><a class="active text-white" href="search.php">Browse</a></li>
      <li><a class="text-white" href="history.php">History</a></li>
      <li><a class="text-white" href="profile.php">Profile</a></li>
    </ul>
  </div>

  <div class="order">
      <?php
          // CALL SOAP API
          $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl");
          $params = array(
              "arg0" => $bookid
          );
          $response = $client->__soapCall("getDetail", $params);
          $detail = json_encode($response);
          $detail = json_decode($detail, true);
          // var_dump($detail);

          // CONNECT TO PROBOOKS DATABASE
          $con = mysqli_connect("localhost","root","","probooks");

          if (mysqli_connect_errno()) {
              echo "Failed to connect to MySQL: " . mysqli_connect_error();
          };

          // Get book review
          $sql_review = " SELECT bookid, content, round(rating, 1) as rating, username, image FROM (ordering JOIN review ON (ordering.id = orderid)) JOIN user USING (username) WHERE bookid = \"$bookid\" ORDER BY review.id DESC; ";
          $res_review = mysqli_query($con, $sql_review);

          // Get book rating
          $sql_rating = "SELECT coalesce(round(avg(rating),1), 0) as rate FROM review JOIN ordering ON (ordering.id = orderid) WHERE bookid = \"$bookid\"; ";
          $res_rating = mysqli_query($con, $sql_rating);
          $row_rating = mysqli_fetch_assoc($res_rating);

          $star_yellow = "star-active.png";
          $star_black = "star-inactive.png";

          // Get Number of Transaction
          $qry_num_transaction = "SELECT MAX(ID) as id FROM ordering;";
          $result = mysqli_fetch_assoc(mysqli_query($con, $qry_num_transaction));
          $num = $result['id'] + 1;

          function insertOrder($conn, $username, $bookid, $cnt) {
              $date = getdate();
              $tgl = "{$date["year"]}-{$date["mon"]}-{$date["mday"]}";

              $sql = "INSERT INTO ordering (username, bookid, count, `date`) VALUES ('$username', \"$bookid\", '$cnt', '$tgl');";
              echo $bookid."<br>";
              echo "$sql";
              
              $res = mysqli_query($conn, $sql);
              if ($res) {
                  echo "success";
              } else {
                  echo "error".mysql_error();
              }
          }

          if (isset($con, $username, $bookid, $_POST['selected'])) {
              insertOrder($con, $username, $bookid, $_POST['selected']);
          }

          
          $kategories = $detail['kategori'];
          
          echo "
              <table class='desc-book'>
              <tr>
                  <td>
                      <h1 class='text-orange judul'>{$detail['judul']}</h1>
                      <div class='author'>";
          if (gettype($detail['penulis']) === "array") {
              echo (implode(", ", $detail['penulis']));
          } else {
              echo ($detail['penulis']);
          }  
                      echo"</div>
                      <div class='desc'>{$detail['sinopsis']}</div><br>
                      <a class='kategori'> Kategori: </a>";
          
          
          if (gettype($kategories) === "array") {
            echo"<br><ul> ";
            for ($x = 0; $x < count($kategories); $x++) {
                echo "<li>{$kategories[$x]}</li> ";
            }
            echo"</ul>";
          } else {
            echo"$kategories<br>";
          }
          
          if($detail['harga'] > 0){
            echo " <a class='harga'> Harga: Rp {$detail['harga']} </a><br>";
          }else{
            echo " <a class='harga'> NOT FOR SALE </a><br>";
          }

          echo "
                  </td>
                  <td class='picture'>
                      <img src='{$detail['gambar']}' class='img-right'>
                      <br>
          ";

          // get real rating
          $servername = "localhost";
          $userdb = "root";
          $password = "";
          $dbname = "probooks";
          
          // Create connection
          $conn = new mysqli($servername, $userdb, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT AVG(rating) avg_rating FROM review join ordering on review.orderid = ordering.id WHERE bookid = '$bookid' GROUP BY bookid";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $detail['rating'] = $row['avg_rating'];
          } else {
            $detail['rating'] = '0.0';
          }
          $conn->close();  

          for ($x = 0; $x < floor($detail['rating']); $x++) {
              echo "<img src='public/img/{$star_yellow}' class='star'>";
          }

          for ($x = floor($detail['rating']); $x < 5; $x++) {
              echo "<img src='public/img/{$star_black}' class='star'>";
          }

          echo "   
                      <br>
                      <center><b>". number_format($detail['rating'], 1, '.', ''). "/ 5.0</b></center>
                  </td>
              </tr>
              </table>
          ";

          if($detail['harga'] > 0){
            echo "
                <h3>Order</h3>
                Jumlah: 
                <select id='dropdown'>
                    <option value='1'>1</a>
                    <option value='2'>2</a>
                    <option value='3'>3</a>
                    <option value='4'>4</a>
                    <option value='5'>5</a>
                </select>
                <br>
                <button id='myBtn' type='button' onclick='order(\"$bookid\")'>Order</button>
                <br>
                <div id='MyBtn'>
                    <div id='myModal' class='modal'>
                        <div class='modal-content'>
                            <span class='close'>&times;</span>
                            <br>
                            <p class='modal-text'>
                            <div class='loader' style='display: none' id = 'loader'>          
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            ";
          }
          
      ?>

    <h3>Recommended</h5>
    <?php
      $options = array(
        'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
        'style'=>SOAP_RPC,
        'use'=>SOAP_ENCODED,
        'soap_version'=>SOAP_1_1,
        'cache_wsdl'=>WSDL_CACHE_NONE,
        'connection_timeout'=>15,
        'trace'=>true,
        'encoding'=>'UTF-8',
        'exceptions'=>true,
      );
      $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl", $options);
      if (sizeof($detail['kategori']) <= 1) {
        $params = array(
            "arg0" => [$detail['kategori']]
        );
      } else {
        $params = array(
            "arg0" => $detail['kategori']
        );
      }
      
      $response = $client->__soapCall("getRecommendation", $params);
        //   var_dump($response);
        // Call SOAP for GetDetail
        
        $params = array(
            "arg0" => $response
        );
        
        $response = $client->__soapCall("getDetail", $params);
        $rec = json_encode($response);
        $rec = json_decode($rec, true);

        echo"<div class='container clearfix'>
                <div class='book-info'> 
                    <a href='order.php?bookid=$rec[id]' style='text-decoration: none'>    
                    <img class='book-pict' src={$rec["gambar"]}>
                    <p class='book-title'>{$rec["judul"]} </p>
                    </a>
                    <p class='author-book'>";
                    if (gettype($rec['penulis']) === "array") {
                        echo (implode(", ", $rec['penulis']));
                    } else {
                        echo ($rec['penulis']);
                    } 
                    echo"
                    </p>
                </div>
            </div>";
    ?>

    <h3>Reviews</h3>

    <?php
      while ($row_review = mysqli_fetch_assoc($res_review)) {
        echo "
          <table>
            <tr>
              <td>
                <img src={$row_review['image']} class='img-left'>
              </td>
              <td class='desc-review'>
                <div class='uname'>@{$row_review['username']}</div>
                <div class='rev'>{$row_review['content']}</div>
              </td>
              <td class='user-rating'>
                <img src='public/img/star-active.png' class='star-one'>
                <center><b>" . number_format($row_review['rating'], 1). " / 5.0</b></center>
              </td>
            </tr>
          </table>
        ";
      }
    ?>
    <script>

      function getDetail(id){
        document.getElementById("loader").style.display = "block";
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            probooks.details = JSON.parse(this.responseText);
            console.log('done');
            document.getElementById("loader").style.display = "none";
            }
          };
        xhttp.open("POST", "./soapclient.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id="+id);
      }

      function order(id) {
        var orderingid;
        document.getElementById("loader").style.display = "block";
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
        if (!xmlhttp) {
          var xmlhttp = new XMLHttpRequest();
        }
        var e = document.getElementById("dropdown");
        var quantity = encodeURIComponent(e.options[e.selectedIndex].value);
        var url="soapclient.php";
        var param = "idbook=" + id + "&quantity=" + quantity +"&nomorPengirim=" + <?php echo $cardnumber; ?>;
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            console.log(xmlhttp.responseText);
            if(xmlhttp.responseText == true){
              document.getElementById("loader").style.display = "none";
              var orderingid = addtoordering(<?php echo("'$username'") ?>, id, quantity);
              var modal = document.getElementById("myModal");
              var btn = document.getElementById("MyBtn");
              var span = document.getElementsByClassName("close")[0];
              document.getElementsByClassName("modal-text")[0].innerHTML ="<img src='public/img/tick.png' class='img-tick'><b>Pemesanan Berhasil!<br></b>Nomor Transaksi : <span id='nomortrans'></span>";
              addpembelian(id, quantity);
              modal.style.display = "block";                                                    
              span.onclick = function() {
                modal.style.display = "none";
                document.getElementsByClassName("modal-text")[0].innerHTML = "";
              }
              window.onclick = function(event) {
                if (event.target == modal) {
                  modal.style.display = "none";
                  document.getElementsByClassName("modal-text")[0].innerHTML = "";
                }
              }
            } else {
              console.log("transaksi gagal bos");
              document.getElementById("loader").style.display = "none";
              var modal = document.getElementById("myModal");
              var btn = document.getElementById("MyBtn");
              var span = document.getElementsByClassName("close")[0];
              document.getElementsByClassName("modal-text")[0].innerHTML = "Saldo anda kurang";
              modal.style.display = "block";                                                    
              span.onclick = function() {
                modal.style.display = "none";
                document.getElementsByClassName("modal-text")[0].innerHTML = "";
              }
              window.onclick = function(event) {
                if (event.target == modal) {
                  modal.style.display = "none";
                  document.getElementsByClassName("modal-text")[0].innerHTML = "";
                }
              }
            }
          }
        }
        xmlhttp.send(param);
      }

      function addpembelian(idbook, quantity){
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "./soapclient.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("idbook="+idbook+"&quantity="+quantity+"&add=true");
      }

      function addtoordering(username, bookid, count){
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "./utils/addtoordering.php", true);
        xhttp.onreadystatechange = function(){
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            document.getElementById("nomortrans").innerHTML = this.responseText;
          }
        };
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username="+username+"&bookid="+bookid+"&count="+count);
      }

    </script>
  </div>
</body>
</html>