<!doctype html>
<html lang="en">
<head>
    <title>Hungry Campus</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hungry Campus</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Locations
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Cafeteria</a>
                        <a class="dropdown-item" href="#">Chick Fil A</a>
                        <a class="dropdown-item" href="#">Starbucks</a>
                        <a class="dropdown-item" href="#">Papa Johns</a>
                        <a class="dropdown-item" href="#">Einstein Bagels </a>
                        <a class="dropdown-item" href="#">Pita Pit</a>
                    </div>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Login</a>
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
                </p>
            </div>
        </div>
     </div>
     <div class="row">
         <div class="col-md-6">
             <div class="create">
                 <h3>Leave a review!</h3>
                 <form name="newReview" action="create.php" method="post">
                     <div class="form-group">
                         <label name="eatery">Eatery</label>
                         <select id="eatery" name="eatery" class="form-control">
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
                             ?>
                         </select>
                     </div>
                     <div class="form-group">
                         <label name="title">Title:</label>
                         <input name="title" id="title" class="form-control">
                     </div>
                     <div class="form-group">
                         <label name="review">Your thoughts:</label>
                         <textarea id="review" name="review" class="form-control"></textarea>
                     </div>
                     <div class="form-group">
                         <label name="rating">Rating</label>
                         <select id="rating" name="rating">
                             <option>1</option>
                             <option>2</option>
                             <option>3</option>
                             <option>4</option>
                             <option>5</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label name="user">Your Name</label>
                         <input name="user" id="user" class="form-control">
                     </div>
                     <input type="submit" value="Submit"">
                 </form>
             </div>
         </div>
         <div class="col-md-6">
             <?php
             $conn2 = new mysqli("localhost", "group6", "fall2017188953", "group6");

             if($conn2->connect_error){
                 die("Connection failed : " . $conn->connect_error);
             }
             $query2 = $conn2->prepare("SELECT Post.postID, Post.title, Post.review, Post.rating, Post.user, Eatery.eateryName FROM Post INNER JOIN Eatery ON Post.eateryID = Eatery.eateryID");
             $query2->execute();
             $query2->bind_result($postID, $title, $review, $rating, $user, $eateryName);

             while($query2->fetch()){
                 echo "            
                    <div>
                    <h3>$eateryName</h3>
                    <h3>$title</h3>
                    <p>$review</p>
                    <p>$rating</p>
                    <p>$user</p>
                    <a href=\"#\" class=\"btn btn-primary\">Full Post</a>
                    </div>
                     ";
             }
             ?>
            <div class="post">
                    <h3>Recent post</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et massa sit amet justo mattis bibendum at eu sapien. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
                    <a href="#" class="btn btn-primary">Full Post</a>
            </div>
             <hr>
             <div class="post">
                 <h3>Recent post</h3>
                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et massa sit amet justo mattis bibendum at eu sapien. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
                 <a href="#" class="btn btn-primary">Full Post</a>
             </div>
             <hr>
             <div class="post">
                 <h3>Recent post</h3>
                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et massa sit amet justo mattis bibendum at eu sapien. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </p>
                 <a href="#" class="btn btn-primary">Full Post</a>
             </div>
             <hr>
         </div>
     </div>
 </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: kbell
 * Date: 11/14/2017
 * Time: 10:59 AM
 */