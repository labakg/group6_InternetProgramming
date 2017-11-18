<?php
    session_start();
    $username = $_SESSION['username'];

    if ($username == ''){
        header("Location: index.php");
    }

    session_destroy();

    header("Location: index.php");

