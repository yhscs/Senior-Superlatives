<body>

<?php
 
$connect=mysqli_connect("HOST_HERE","DB_HERE","PASS_HERE","USER_HERE");

if(mysqli_connect_errno())
{
    echo "Error".mysqli_connect_error();
}

$query = "SELECT question FROM questions"; 
$result = mysqli_query($connect,$query);

$query_student = "SELECT * FROM STUDENT$"; 
$result_student = mysqli_query($connect,$query_student);

if (isset($_POST['submit_response'])){ 

       	if($_POST['students_box'])
        {
         while ($row = mysqli_fetch_array($result)){
            while ($row_student = mysqli_fetch_array($result_student)){

            $question = mysqli_real_escape_string($connect,$row['question']);
            $ID_student = mysqli_real_escape_string($connect,$row['ID']);

            mysqli_query($connect, "UPDATE yhscs_seniors . STUDENT$ SET $question = $question + 1 WHERE STUDENT$ . ID  = $ID_student");
         }
        } 
       }
    
        header("Location: completed_vote.php");  
        die("Redirecting to: completed_vote.php"); 
    }
echo'<Form Name ="forms" Method ="POST" ACTION = "dev_questions.php">
<h1>Questions</h1>
<table>  ';
    /*while($rows){
        <tr> 
            <td><?php echo $row['id']; ?></td> 
            <td><?php echo htmlentities($row['question'], ENT_QUOTES, 'UTF-8'); ?></td> 
            <td><select name = "students_box">
            <option value = "0"> --Select Vote-- </option>";
            <?php 
		while($rows_student){
		{
    		echo "<option value = '<?php echo $row_student['ID'];?>'> <?php echo $row_student['name'];?> </option>";
		}
	      } 
            </td> </select>
        </tr> 
    }
</table>
<input type='submit' name = 'submit_response' value='Submit' action='POST'>
<a href="index.php">Logout</a>
</form>';*/

?>
</body>
