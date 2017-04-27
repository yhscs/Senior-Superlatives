<?php 
//Checked by Sam. Status: Good.
require("common.php"); 
    if(empty($_SESSION['user'])) 
    { 
        header("Location: logout.php"); 
         
        die("Redirecting to logout.php"); 
    } 
?>
<h1>Thank you for voting</h1>
Please press the link below to logout.
<a href="logout.php">Logout</a>
