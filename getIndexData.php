<?php
session_start();
$username = $_SESSION['username'];
$isAdmin = $_SESSION['isAdmin'];
$selection = $_GET['selection'];
$conn2 = new mysqli("localhost", "group6", "fall2017188953", "group6");

if($conn2->connect_error){
    die("Connection failed : " . $conn2->connect_error);
}

if($selection == 'all'){
    $query2 = $conn2->prepare("SELECT Post.postID, Post.title, Post.review, Post.rating, User.userName, Eatery.eateryName, Post.time FROM Post INNER JOIN Eatery ON Post.eateryID = Eatery.eateryID INNER JOIN User ON Post.userID = User.userID");
}else{
    $query2 = $conn2->prepare("SELECT Post.postID, Post.title, Post.review, Post.rating, User.userName, Eatery.eateryName, Post.time FROM Post INNER JOIN Eatery ON Post.eateryID = Eatery.eateryID INNER JOIN User ON Post.userID = User.userID WHERE Post.eateryID = ?");
    $query2->bind_param("i", $selection);
}

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
?>