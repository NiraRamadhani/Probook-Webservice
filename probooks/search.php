<?php
    // check whether user is already logged in or not
    // $config = include '/config/db.php';
    
    require_once 'utils/validate-session.php';

    // Get data from cookie
    $username = $_COOKIE['username'];
    $access_token = $_COOKIE['access_token'];
    
    validate($access_token, $username, null);
    checkSession();
    
    setcookie('access_token', $access_token, time() + 600, '/');
    setcookie('username', $username, time() + 600, '/');
?>
<!DOCTYPE html>
<html ng-app="probookApp">
<head>
  <meta charset="utf-8" />
  <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
  <title>Search Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
  <link rel="stylesheet" type="text/css" href="public/css/navbar.css">
  <link rel="stylesheet" type="text/css" href="public/css/body.css">
  <link rel="stylesheet" type="text/css" href="public/css/search-books.css">
  <link rel="stylesheet" type="text/css" href="public/css/search-result.css">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.min.js"></script>
  <script src="main.js"></script>
</head>
<body>
  <!-- NAVBAR -->
    <div id="nav">
        <ul>
            <li id="li-pro-book"><a href="search.php" id="pro-book">
                <span class="text-yellow">Pro</span><span class="text-white">-Book</span>
            </a></li>
            <li id="li-username"><a href="profile.php" id="username" class="text-white">Hi, <?php echo "$username"; ?></a></li>
            <li id="li-logout"><a href="logout.php" id="logout" class="text-white">
                <img src="public/img/power.png" alt="Logout" height="30" width="30">
            </a></li>
        </ul>
        <ul id="menu">
            <li><a class="active text-white" href="search.php">Browse</a></li>
            <li><a class="text-white" href="history.php">History</a></li>
            <li><a class="text-white" href="profile.php">Profile</a></li>
        </ul>
    </div>
  <!-- CONTENT -->
    <div class="content" ng-controller="ProbookController as probook">
      <div class="container text-align-left">
          <h2 class="text-orange">Search Book</h2>
      </div>
      <div class="container text-align-right">
        <form name="search" ng-submit="probook.search()">
          <input type="text" ng-model="probook.searchTerm" id="search-box" class="input" size="30" placeholder="Search your book here">
          <input type="submit" value="Search" class="input text-white" id="submit-button">
        </form>

        <div class="loader" style="display: none" id = "loader">
          
        </div>

      
      </div>  
      <div class="content">
        <div class="container text-align-left result-row" id="hasil0" style="display: none;">
        <table class="full-width" style="overflow: auto;">
            <tr>
                <td id="search-title">
                    <h1 class="text-orange">Search Result</h2>
                </td>
                <td id="found-count" class="text-align-right vertical-align-bottom">
                    <p>Found <span id="num-rows">0</span> result(s)</p>
                </td>
            </tr>
        </table>
        </div>
        <div class="container text-align-left" ng-if="probook.books.length > 0">
        <table class="full-width">
            <tr>
                <td id="search-title">
                    <h1 class="text-orange">Search Result</h2>
                </td>
                <td id="found-count" class="text-align-right vertical-align-bottom">
                    <p>Found <span id="num-rows">{{probook.books.length}}</span> result(s)</p>
                </td>
            </tr>
        </table>
        </div>
          <!-- <div class="container"> -->
          <div class="result-row" ng-repeat="book in probook.books">  
          <table class="search-result" class="full-width">
              <tr>
                <td class='picture vertical-align-top'>
                  <img ng-src= "{{book.gambar}}" class='img-book'>
                </td>
                <td class='book-data text-align-left vertical-align-top'>
                  <p class='title-book text-orange'>{{book.judul}}</p>
                  <p class='author-book'>
                  {{printAuthor(book.penulis)}} - {{book.rating ? (book.rating | number:1) : '0.0' }}/5.0 ({{book.votesCount}} votes)
                  </p>
                  <p class='desc-book'>{{book.sinopsis}}</p>
                </td>
              </tr>
              <tr class='button-detail text-align-right'>
                <td colspan='2'>
                  <form method='get' action='order.php'>
                      <input type='hidden' id='book-id' name='bookid' value={{book.id}}>
                      <input class='submit-button text-white' type='submit' value='Detail'>
                    </form>
                </td>
              </tr>                
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>  
</body>
</html>