
<body>

<?php
 
$connect=mysqli_connect("HOST_HERE","DB_HERE","PASS_HERE","USER_HERE");

if(mysqli_connect_errno())
{
    echo "Error".mysqli_connect_error();
}

if (isset($_POST['add']))
{
   $input_question = $_POST['question'];

   if (!$input_question) {
   $error_msg = "Please Type in a question.";
   }
   else{
   mysqli_query($connect,"INSERT INTO questions (question) VALUES ('$input_question')");
   mysqli_query($connect,"ALTER TABLE  `STUDENT$` ADD  `$input_question` INT( 11 ) NOT NULL");
   }
}

if (isset($_POST['update']))
{
    $checkbox = $_POST['checkbox'];
    $count = count($checkbox);

    for($i=0;$i<$count;$i++)
    {
        if(!empty($checkbox[$i])){
        $question = mysqli_real_escape_string($connect,$checkbox[$i]); 
        mysqli_query($connect,"DELETE FROM questions WHERE question = '$question'"); 
        mysqli_query($connect,"ALTER TABLE STUDENT$ DROP $question;"); 
        } 

    } 

} 

$query = "SELECT * FROM questions"; 
$result = mysqli_query($connect,$query);// execute query

echo "<form action='dev_edit_questions.php' method='POST'>"; // submit page on itself


echo"<h1>Edit Questions</h1>

     Add or Delete Questions<br/>
     <input type = 'text' name = 'question' value = ''/></br>";
     if(isset($error_msg) && $error_msg) {
    echo "<p style=\"color: red;\">*",htmlspecialchars($error_msg),"</p>";
    }

echo"<input type='submit' name = 'add' value='Add' action='POST'>
     </br></br>

     <table width='400' border='0' cellspacing='1' cellpadding='0'>
     <tr>	
     <table width='400' border='0' cellpadding='3' cellspacing='1' bgcolor='#CCCCCC'>	
     <tr>
	<td align='center' bgcolor='#FFFFFF'>Delete</td>
	<td align='center' bgcolor='#FFFFFF'><strong>Question</strong></td>
      </tr></tr>";

while ($row = mysqli_fetch_array($result)){ //fetch array
    $question=mysqli_real_escape_string($connect,$row['question']);
    echo "<tr>
            <td align='center' bgcolor='#FFFFFF'><input type='checkbox' name='checkbox[]' value='$question'></td>
            <td bgcolor='#FFFFFF'>" . $row['question'] . " </td>
         </tr>";
}
mysqli_free_result($result);
echo "</table>";
?>
</br>
<tr>
<td colspan="5" align="center"><input name="update" type="submit" id="Delete" value="Update" action="POST"></td><br/>
</tr>

<br><a href="dev_private.php">Go Back</a><br/>
</form>

</body>
