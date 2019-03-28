<?php
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
  $sql = "SELECT AVG(rating) avg_rating, Count(ordering.id) cnt FROM review join ordering on review.orderid = ordering.id WHERE bookid = '{$_POST['idbook']}' GROUP BY bookid";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
  } else {
    $row = array(
      "rating" => 0,
      "cnt" => 0
    );
    echo json_encode($row);
  }
  $conn->close();      
?>