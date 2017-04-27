<?php 
	//Checked by sam. Status: Good.
    require("common.php"); 

	function noHTML($input, $encoding = 'UTF-8'){
		return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding, false);
	}

    if(empty($_SESSION['user'])) 
    { 
        // If false, redirect to index.php 
        header("Location: index.php"); 
         
        die("Redirecting to index.php"); 
    }

	if($_SESSION["voted"]){
		header("Location: index.php");
		exit();
	}
	
	//Checks for double voting
 	$query = "SELECT `Voted` FROM `users` WHERE `id` = ?;"; 
	$query_params = array($_SESSION["user"]["id"]);
    try  {  
        $stmt = $db->prepare($query); 
        $stmt->execute($query_params); 
		$result = $stmt->fetch();
    } 
    catch(PDOException $ex) 
    {  
        die("Failed to run query: " . $ex->getMessage()); 
    }
	if($result["Voted"] == 1){
		$_SESSION["voted"] = true;
		header("Location: index.php");
		exit();
	}
	//End double voting check

    $query = "SELECT * FROM questions"; 
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
         foreach($rows as $category){
			 	$student = $_POST['category'.$category['id']];
			 	if($student === "noVal"){
					continue;
				}
				$query = "INSERT INTO `votes` (`id`, `category`) VALUES (?, ?)";
            	$query_params = array($student, $category['id']);
            try {
				 $stmt = $db->prepare($query); 
				 $stmt ->execute($query_params); 
             } 
       
            catch(PDOException $ex) { 
            	die("Failed to run query: ". $ex->getMessage()); 
            }
       }
		
		$query = "UPDATE `users` SET `Voted`= 1 WHERE `username` = ?;"; 
		$query_params = array($_SESSION["username"]);
		try  {  
			$stmt = $db->prepare($query); 
			$stmt->execute($query_params); 
		} 
		catch(PDOException $ex) 
		{  
			die("Failed to run query: " . $ex->getMessage()); 
		}
		$_SESSION["voted"] = true;
       
        header("Location: completed_vote.php");  
        die("Redirecting to: completed_vote.php"); 
    }
?>

<form Name ="forms" Method ="POST" ACTION = "dev_questions.php">
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
            <td style="color:#FFFFFF"><?php echo noHTML($row['question']); ?></td> 
            <td><select name = "category<?php echo noHTML($row['id']); ?>">
            <option value = "noVal"> --Select Vote-- </option>
            <?php 
			foreach($rows_student as $student) : ?> 
				<option value = '<?php echo noHTML($student['ID']); ?>'> <?php echo noHTML($student['name']); ?> </option>
	      <?php endforeach; ?>  
            </td> </select>
        </tr> 
    <?php endforeach; ?> 
</table>
<input type='submit' name = 'submit_response' onclick="return confirm('Are you sure?')" value='Submit' action='POST'>
<a href="index.php">Logout</a>
</form>