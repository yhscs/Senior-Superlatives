
<body>

<?php
 
$connect=mysqli_connect("HOST_HERE","DB_HERE","PASS_HERE","USER_HERE");

if(mysqli_connect_errno())
{
    echo "Error".mysqli_connect_error();
}

if (isset($_POST['update']))
{
    $checkbox = $_POST['checkbox'];
    $count = count($checkbox);
    for($i=0;$i<$count;$i++)
    {
        if(!empty($checkbox[$i]))
        { /* Check checkbox */
 
        $id = mysqli_real_escape_string($connect,$checkbox[$i]); // escape string 
        mysqli_query($connect,"DELETE FROM users WHERE id = '$id'"); // execute query, use apostrophe in variable 
 
        } 
 
    } 
 
} 
 
$query = "SELECT * FROM users"; 
$result = mysqli_query($connect,$query);// execute query

echo "<form action='dev_alt_memberlist.php' method='POST'>"; // submit page on itself


echo"<h1>Student List</h1>
     <table width='400' border='0' cellspacing='1' cellpadding='0'>
     <tr>	
     <table width='400' border='0' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>
     <tr>
       <td bgcolor='#FFFFFF'>&nbsp;</td>
       <td colspan='4' bgcolor='#FFFFFF'><strong>Member List</strong> </td>
     </tr>	
     <tr>
	<td align='center' bgcolor='#FFFFFF'>Delete</td>
	<td align='center' bgcolor='#FFFFFF'><strong>ID</strong></td>
	<td align='center' bgcolor='#FFFFFF'><strong>Username</strong></td>
	<td align='center' bgcolor='#FFFFFF'><strong>Admin</strong></td>
	<td align='center' bgcolor='#FFFFFF'><strong>Email</strong></td>
      </tr></tr>";

while ($row = mysqli_fetch_array($result)){ //fetch array
    $id=mysqli_real_escape_string($connect,$row['id']);
    echo "<tr>
            <td align='center' bgcolor='#FFFFFF'><input type='checkbox' name='checkbox[]' value='$id'></td>
            <td bgcolor='#FFFFFF'>" . $row['id'] . "</td>
            <td bgcolor='#FFFFFF'>" . $row['username'] . "</td>
            <td bgcolor='#FFFFFF'>" . $row['admin_rights'] . "</td>
            <td bgcolor='#FFFFFF'>" . $row['email'] . "</td>
         </tr>";
}
mysqli_free_result($result);
echo "</table>";
?>

<tr>
<td colspan="5" align="center"><input name="update" type="SUBMIT" id="Delete" value="Update" action="POST"></td>
</tr>

<br><a href="dev_private.php">Go Back</a><br/>
</form>

</body>