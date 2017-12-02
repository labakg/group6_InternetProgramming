<?php

session_start();
$username = $_SESSION['username'];
$isAdmin = $_SESSION['isAdmin'];
$userID = $_SESSION['userID'];

if($username == ""){
    header("Location: ../loginPage.php");
}


$eateryID = $_POST['eatery'];
$title = $_POST['title'];
$title = preg_replace('#<(.*?)>(.*?)</(.*?)>#is', '', $title);
$review = $_POST['review'];
$review = preg_replace('#<(.*?)>(.*?)</(.*?)>#is', '', $review);
$rating = $_POST['rating'];
$date = date("y.m.d h:i:S a");
$postID = $_POST['postID'];

$conn = new mysqli("localhost", "group6", "fall2017188953", "group6");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->prepare("UPDATE Post SET title=?, review=?, rating=?, userID=?, eateryID=? WHERE postID=?");

$query->bind_param("sssiii", $title, $review, $rating, $userID, $eateryID, $postID);

if($query->execute() === TRUE){
    echo "Record updated successfully";
}else{
    echo "Error: " . $query . "<br>" . $conn->error;
}
$query->close();
$conn->close();

switch($eateryID){
    case 1:
        header("Location: ../locations/cafeteria.php");
        break;
    case 2:
        header("Location: ../locations/ChickFilA.php");
        break;
    case 3:
        header("Location: ../locations/starbucks.php");
        break;
    case 4:
        header("Location: ../locations/papajohns.php");
        break;
    case 5:
        header("Location: ../locations/einsteinbagels.php");
        break;
    case 6:
        header("Location: ../locations/pitapit.php");
        break;
}