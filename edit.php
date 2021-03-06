<!doctype html>
<html lang="en">
<head>
    <title>Hungry Campus</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"</script>
    <script>
    $(document).ready(function()){
        $("#newReview").validate();
    </script>

    <style>
        body{background-color: darkblue}
        .img {float: right; height: 20% ; width: 20%}

    </style>

</head>
<body>
<?php
    session_start();
    $toUpdate = $_GET['post'];
    $conn3 = new mysqli("localhost", "group6", "fall2017188953", "group6");

    if($conn3->connect_error){
        die("Connection failed : " . $conn->connect_error);
    }
    $query1 = $conn3->prepare("SELECT Post.postID, Post.title, Post.review, Post.rating, User.userName, Eatery.eateryName, Post.time, Post.userID, Post.eateryID FROM Post INNER JOIN Eatery ON Post.eateryID = Eatery.eateryID INNER JOIN User ON Post.userID = User.userID WHERE Post.postID =?");
    $query1->bind_param('i', $toUpdate);
    $query1->execute();
    $query1->bind_result($postID, $title, $review, $rating, $user, $eateryName, $date, $userID, $eateryReq);
    $query1->fetch();
    $conn3->close();
    $username = $_SESSION['username'];
    $isAdmin = $_SESSION['isAdmin'];

    if($username == "" || $username != $user ){
        header("Location: ../index.php");
    }
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="../index">Hungry Campus</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../aboutUs.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Locations
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../locations/cafeteria.php">Cafeteria</a>
                    <a class="dropdown-item" href="../locations/ChickFilA.php">Chick Fil A</a>
                    <a class="dropdown-item" href="../locations/starbucks.php">Starbucks</a>
                    <a class="dropdown-item" href="../locations/papajohns.php">Papa Johns</a>
                    <a class="dropdown-item" href="../locations/einsteinbagels.php">Einstein Bagels </a>
                    <a class="dropdown-item" href="../locations/pitapit.php">Pita Pit</a>
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
                        echo '<a class="dropdown-item" href="../loginPage.php">Login</a>';
                    }else{
                        echo '<a class="dropdown-item" href="../logout.php">Logout</a>';
                    }
                    ?>
                </div>
            </li>
        </ul>
    </div>
</nav>
<br>
<?php
    echo "<div class='container'>";
    echo "<div class='row'>";
        echo "<div class='col-md-12'>";
            echo "<div class='jumbotron'>";
                echo "<h3>Leave a review!</h3>";
                echo "<form name='updateReview' action='update.php' method='post'>";
                    echo "<div class='form-group'>";
                        echo "<input id='postID' name='postID' value='$postID' hidden>";
                        echo "<label name='eater'>Eatery</label>";
                            echo "<select id='eatery' name='eatery' class='form-control'>";
                            $conn = new mysqli("localhost", "group6", "fall2017188953", "group6");

                            if($conn->connect_error){
                                die("Connection failed : " . $conn->connect_error);
                            }
                            $query = $conn->prepare("SELECT eateryID, eateryName FROM Eatery");
                            $query->execute();
                            $query->bind_result($eateryID, $eateryName);

                            while ($query->fetch()){
                                if ($eateryID == $eateryReq){
                                    echo "<option value='$eateryID' selected>$eateryName</option>";
                                }else {
                                    echo "<option value='$eateryID'>$eateryName</option>";
                                }
                            }
                        echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                        echo "<label name='title'>Title:</label>";
                       echo "<input name='title' id='title' class='form-control' value='$title' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                        echo "<label name='review'>Your thoughts:</label>";
                        echo "<textarea id='review' name='review' class='form-control' required>$review</textarea>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                        echo "<label name='rating'>Rating</label>";
                        echo "<select id='rating' name='rating'>";
                        if ($rating == 1) {
                            echo "<option selected>1</option>";
                        } else {
                            echo "<option>1</option>";
                        }
                        if ($rating == 2) {
                            echo "<option selected>2</option>";
                        } else {
                            echo "<option>2</option>";
                        }
                        if ($rating == 3) {
                            echo "<option selected>3</option>";
                        } else {
                            echo "<option>3</option>";
                        }
                        if ($rating == 4) {
                            echo "<option selected>4</option>";
                        } else {
                            echo "<option>4</option>";
                        }
                        if ($rating == 5) {
                            echo "<option selected>5</option>";
                        } else {
                            echo "<option>5</option>";
                        }
                        echo "</select>";
                        echo "</div>";


                    echo "<button class='btn btn-primary' type='submit'>Submit</button>";
                    switch($eateryReq){
                        case 1:
                            echo '<a class="btn btn-danger" href="../locations/cafeteria.php" role="button">Cancel</a>';
                            break;
                        case 2:
                            echo '<a class="btn btn-danger" href="../locations/ChickFilA.php" role="button">Cancel</a>';
                            break;
                        case 3:
                            echo '<a class="btn btn-danger" href="../locations/starbucks.php" role="button">Cancel</a>';
                            break;
                        case 4:
                            echo '<a class="btn btn-danger" href="../locations/papajohns.php" role="button">Cancel</a>';
                            break;
                        case 5:
                            echo '<a class="btn btn-danger" href="../locations/einsteinbagels.php" role="button">Cancel</a>';
                            break;
                        case 6:
                            echo '<a class="btn btn-danger" href="../locations/pitapit.php" role="button">Cancel</a>';
                            break;
                        default:
                            echo '<a class="btn btn-danger" href="../index.php" role="button">Cancel</a>';
                            break;
                    }
                    $conn->close();
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>