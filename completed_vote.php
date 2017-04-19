<?php 
require("common.php"); 
    if(empty($_SESSION['user'])) 
    { 
        header("Location: index.php"); 
         
        die("Redirecting to index.php"); 
    } 
?>
<h1>Thank you for voting</h1>
Please press the link below to logout.
<a href="index.php">Logout</a>
