<?php

session_start();
$username = $_SESSION['username'];
$isAdmin = $_SESSION['isAdmin'];
if ($username == '' || $isAdmin != 1){
    header("Location: ../index.php");
}

$postID = $_GET['post'];

$conn = new mysqli("localhost", "group6", "fall2017188953", "group6");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->prepare("DELETE FROM Post WHERE postID=?");
$query->bind_param("i", $postID);

if ($query->execute() === TRUE){
    echo "Successfully deleted";
}else{
    echo "Error: " . $query . "<br>" . $conn->error;
}

$query->close();
$conn->close();
header("Location: ../index.php");