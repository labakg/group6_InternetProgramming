<!doctype html>
<html lang="en">
<head>
    <title>Hungry Campus</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <script>

        function ajaxFunc(){
            var ajaxRequest;

            try{
                ajaxRequest = new XMLHttpRequest();
            }catch (e){
                try{
                    ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
                }catch (e){
                    try{
                        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP")
                    }catch (e){
                        alert("Your browser broke!");
                        return false;
                    }
                }
            }

            ajaxRequest.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById("output").innerHTML = this.responseText;
                }
            }

            var selection = document.indexForm.eatery.value;

            ajaxRequest.open("GET", "getIndexData.php?selection=" + selection, true);
            ajaxRequest.send();
        }
    </script>
</head>
<body>
<?php
session_start();
$username = $_SESSION['username'];
$isAdmin = $_SESSION['isAdmin'];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Hungry Campus</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Locations
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="locations/cafeteria.php">Cafeteria</a>
                    <a class="dropdown-item" href="locations/ChickFilA.php">Chick Fil A</a>
                    <a class="dropdown-item" href="locations/starbucks.php">Starbucks</a>
                    <a class="dropdown-item" href="locations/papajohns.php">Papa Johns</a>
                    <a class="dropdown-item" href="locations/einsteinbagels.php">Einstein Bagels </a>
                    <a class="dropdown-item" href="locations/pitapit.php">Pita Pit</a>
                </div>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLogin" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                    if ($username == ""){
                        echo "Login to Account";
                    }else{
                        echo "$username";
                    }
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownLogin">
                    <?php
                    if ($username == ""){
                        echo '<a class="dropdown-item" href="loginPage.php">Login</a>';
                    }else{
                        echo '<a class="dropdown-item" href="logout.php">Logout</a>';
                    }
                    ?>
                </div>
            </li>
        </ul>
    </div>
</nav>
 <div class="container">
     <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="display-3">Hungry Campus </h1>
                <p class="lead">This site allows your to leave reviews and ratings of eating establishments on the UNF Campus </p>
                <hr class="my-4">
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="#" role="button">About us!</a>
                    <?php
                        if($username == ""){
                           echo "<a class='btn btn-primary btn-lg' href='loginPage.php' role='button'>Log In to Contribute!</a>";
                        }else{
                            echo "<a class='btn btn-primary btn-lg' href='posts/review.php' role='button'>Leave a review!</a>";
                        }
                    ?>
                </p>
            </div>
        </div>
     </div>
         <div class="col-md-10">
             <h2>Recent Reviews
             <form name="indexForm" onchange="ajaxFunc()">
                 <div class="form-group">
                     <select id="eatery" name="eatery" class="form-control"> '
                         <option selected value="all"> All Reviews</option>
                         <?php
                         $conn = new mysqli("localhost", "group6", "fall2017188953", "group6");

                         if($conn->connect_error){
                             die("Connection failed : " . $conn->connect_error);
                         }
                         $query = $conn->prepare("SELECT eateryID, eateryName FROM Eatery");
                         $query->execute();
                         $query->bind_result($eateryID, $eateryName);

                         while ($query->fetch()){
                             echo "<option value='$eateryID'>$eateryName</option>";
                         }
                         $query->close();
                         $conn->close();
                         ?>
                     </select>
                 </div>
             </form>
             </h2>
             <hr>
             <p id="output"></p>
             <?php
                /*
             $conn2 = new mysqli("localhost", "group6", "fall2017188953", "group6");

             if($conn2->connect_error){
                 die("Connection failed : " . $conn->connect_error);
             }
             $query2 = $conn2->prepare("SELECT Post.postID, Post.title, Post.review, Post.rating, User.userName, Eatery.eateryName, Post.time FROM Post INNER JOIN Eatery ON Post.eateryID = Eatery.eateryID INNER JOIN User ON Post.userID = User.userID");
             $query2->execute();
             $query2->bind_result($postID, $title, $review, $rating, $user, $eateryName, $date);

             while($query2->fetch()){
                 echo "            
                    <div>
                    <h3>$eateryName</h3>
                    <h3>$title<h3></h3>
                    <p>$review</p>
                    <p>Overalll rating: $rating / 5</p>
                    <p>Posted by: $user on $date</p>
                    <input type='hidden' name='postID' id='postID' value='$postID'>
                    " ;
                     if ($isAdmin == 1){
                        echo "<a class='btn btn-danger' href='delete.php?post=$postID' role='button'>Delete Post</a>";
                     }
                 echo "</div><hr>
                     ";
             }
                */
             ?>

     </div>
 </div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>

