angular.module('probookApp', [])
  .controller('ProbookController', function($scope) {
    var probook = this;
    probook.books = []
    probook.searchTerm = "";
    probook.details = "";

    $scope.printAuthor = function(obj) {
      if (typeof obj === "string") {
        return obj;
      } else {
        return obj.join(", ");;
      }
    }

    probook.search = function(){
      while (probook.books.length > 0){
            probook.books.pop();
          }
      document.getElementById("loader").style.display = "block";
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          
          if (this.responseText === "Soapfault") {
              document.getElementById("loader").style.display = "none";
              document.getElementById("hasil0").style.display = "table";
              
          } else {
            json = JSON.parse(this.responseText);
            angular.forEach(json.item, function(book){
              probook.books.push(book);
            });
            console.log(probook.searchTerm);
            console.log('done');
            console.log(probook.books);
            document.getElementById("loader").style.display = "none";
            probook.getrate();
            $scope.$apply();
          }
         }
        };
      xhttp.open("POST", "./soapclient.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("judul="+probook.searchTerm);
    }

    probook.getrate = function(){
      probook.books.forEach(function(book) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            json = JSON.parse(this.responseText);
            console.log(json);
            book.rating = json['avg_rating'];
            book.votesCount = json['cnt'];
          }
          $scope.$apply();   
        };
        xhttp.open("POST", "./utils/getrate.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("idbook="+book.id);  
      });
    }

    // probook.getDetails = function(id){
    //   if (probook.details != ""){
    //     probook.details == "";
    //   }
    //   document.getElementById("loader").style.display = "block";
    //   var xhttp = new XMLHttpRequest();
    //   xhttp.onreadystatechange = function(){
    //     if (this.readyState == 4 && this.status == 200) {
    //       console.log(this.responseText);
    //       probooks.details = JSON.parse(this.responseText);
    //       console.log('done');
    //       document.getElementById("loader").style.display = "none";
    //       $scope.$apply();
    //      }
    //     };
    //   xhttp.open("POST", "./soapclient.php", true);
    //   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //   xhttp.send("id="+id);
    // }
  })
  