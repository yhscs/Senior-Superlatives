<?php 
    require("common.php"); 
     
    // Remove user's data from session 
    unset($_SESSION['user']); 
     
    // redirect to login.php 
    header("Location: index.php"); 
    die("Redirecting to: index.php");