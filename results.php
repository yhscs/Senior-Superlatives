<body>

<?php
 
$connect=mysqli_connect("HOST_HERE","DB_HERE","PASS_HERE","USER_HERE");

if(mysqli_connect_errno())
{
    echo "Error".mysqli_connect_error();
}

?>