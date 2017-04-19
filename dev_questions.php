<?php 

    require("common.php"); 

    if(empty($_SESSION['user'])) 
    { 
        // If false, redirect to index.php 
        header("Location: index.php"); 
         
        die("Redirecting to index.php"); 
    } 

    $query = "SELECT question FROM questions"; 
    try  {  
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // no $ex->getMessage(). 
        die("Failed to run query: " . $ex->getMessage()); 
    } 

    $rows = $stmt->fetchAll();

    $query_student = "SELECT * FROM STUDENT$"; 
    try {  
        $stmt_student = $db->prepare($query_student); 
        $stmt_student ->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // no $ex->getMessage(). 
        die("Failed to run query: " . $ex->getMessage()); 
    } 

    $rows_student = $stmt_student->fetchAll(); 
    
    if (isset($_POST['submit_response'])){ 

       	if($_POST['students_box'])
        {
         foreach($rows as $row){
            foreach($rows_student as $row_student){
            //$query = "UPDATE STUDENT$ SET :questions = :questions + 1 WHERE STUDENT$ . ID = :id";
            $query = "UPDATE `yhscs_seniors`.`STUDENT$` SET `:questions` = `:questions` + 1 WHERE `STUDENT$`.`ID` = :id";
            $query_params = array(':questions' => $row['question'], ':id' => $row_student['ID']);
            try {
             $stmt = $db->prepare($query); 
             $stmt ->execute($query_params); 
             } 
       
            catch(PDOException $ex) { 
            die("Failed to run query: " . $ex->getMessage()); 
            }
         }
        } 
       }
       
        header("Location: completed_vote.php");  
        die("Redirecting to: completed_vote.php"); 
    }
?>
<script>
function clicked() {
       if (confirm('Do you want to submit?')) {
           yourformelement.submit();
       } else {
           return false;
       }
    }
</script>
<Form Name ="forms" Method ="POST" ACTION = "dev_questions.php">
<style>
body {
    background-color: darkred;
}
</style>
<h1 style="color:#FFFFFF">Questions</h1>
<table>  
    <?php foreach($rows as $row): 
    ?> 
        <tr> 
            <td><?php echo $row['id']; ?></td> 
            <td style="color:#FFFFFF"><?php echo htmlentities($row['question'], ENT_QUOTES, 'UTF-8'); ?></td> 
            <td><select name = "students_box">
            <option value = "0"> --Select Vote-- </option>";
            <?php 
		foreach($rows_student as $row_student) : ?> 
		{
    		echo "<option value = '<?php echo $row_student['ID'];?>'> <?php echo $row_student['name'];?> </option>";
		}
	      <?php endforeach; ?>  
            </td> </select>
        </tr> 
    <?php endforeach; ?> 
</table>
<input type='submit' name = 'submit_response' onclick="return confirm('Are you sure?')" value='Submit' action='POST'>
<script>
function myFunction() {
    alert("I am an alert box!");
}
</script>
<a href="index.php">Logout</a>
</form>