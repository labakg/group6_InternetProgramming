<?php
$eateryID = $_POST['eatery'];
$title = $_POST['title'];
$review = $_POST['review'];
$rating = $_POST['rating'];
$user = $_POST['user'];

$conn = new mysqli("localhost", "group6", "fall2017188953", "group6");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->prepare("INSERT INTO Post (title, review, rating, user, eateryID) Values (?, ?, ?, ?, ?)");

$query->bind_param("sssii", $title, $review, $rating, $user, $eateryID);

if($query->execute() === TRUE){
    echo "New record created successfully";
}else{
    echo "Error: " . $query . "<br>" . $conn->error;
}
$query->close();
$conn->close();
header("Location: index.php");