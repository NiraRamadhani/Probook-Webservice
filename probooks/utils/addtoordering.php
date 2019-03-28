<?php
  $servername = "localhost";
  $userdb = "root";
  $password = "";
  $dbname = "probooks";
  $username = $_POST['username'];
  $bookid = $_POST['bookid'];
  $count = $_POST['count'];
  
  // Create connection
  $conn = new mysqli($servername, $userdb, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $sql = "INSERT INTO ordering(username, bookid, count) VALUES('$username', '$bookid', $count)";
  $result = $conn->query($sql);  
  $sql2 = "SELECT LAST_INSERT_ID() lastid";
  $result2 = $conn->query($sql2);
  if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    echo $row2['lastid'];
  }
?>