<?php
//Checked by sam. Status: Good.
require("common.php");

function noHTML($input, $encoding = 'UTF-8')
{
    return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding, false);
}

if(!isset($_SESSION["user"])){
	header("Location: index.php");
	exit();
}

	$query="SELECT * FROM users WHERE username = :username";
    $query_params = array(':username' => $_SESSION['username']); 
     try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        $row = $stmt->fetch();  
    // user logged status 
    if(empty($_SESSION['user']) || $row['user']['admin_rights'] == "0") 
    { 
        header("Location: index.php"); 
        die("Redirecting to index.php"); 
    }

if (isset($_POST['add']))
{
   $input_question = $_POST['question'];

   if (!$input_question) {
   $error_msg = "Please Type in a question.";
   }
   else{
	   
		$query="INSERT INTO questions (question) VALUES ?;";
		$query_params = array($input_question); 
		try { 
			$stmt = $db->prepare($query); 
			$stmt->execute($query_params); 
		} 
		catch(PDOException $ex) 
		{ 
			die("Failed to run query: " . $ex->getMessage()); 
		}

		$query="ALTER TABLE `STUDENT$` ADD ? INT( 11 ) NOT NULL;";
		$query_params = array($input_question); 
		try { 
			$stmt = $db->prepare($query); 
			$stmt->execute($query_params); 
		} 
		catch(PDOException $ex) 
		{ 
			die("Failed to run query: " . $ex->getMessage()); 
		}
   }
}

if (isset($_POST['update']))
{
    $checkbox = $_POST['checkbox'];
    $count = count($checkbox);

    for($i=0;$i<$count;$i++)
    {
        if(!empty($checkbox[$i])){
			$question = $checkbox[$i]; 
			
			$query="DELETE FROM questions WHERE question = ?;";
			$query_params = array($question); 
			try { 
				$stmt = $db->prepare($query); 
				$stmt->execute($query_params); 
			} 
			catch(PDOException $ex) 
			{ 
				die("Failed to run query: " . $ex->getMessage()); 
			}
			
			$query="ALTER TABLE STUDENT$ DROP ?;";
			$query_params = array($question); 
			try { 
				$stmt = $db->prepare($query); 
				$stmt->execute($query_params); 
			} 
			catch(PDOException $ex) 
			{ 
				die("Failed to run query: " . $ex->getMessage()); 
			}
        } 

    } 

} 

$query="SELECT * FROM questions";
$query_params = array(); 
try { 
	$stmt = $db->prepare($query); 
	$stmt->execute($query_params);
} 
catch(PDOException $ex) 
{ 
	die("Failed to run query: " . $ex->getMessage()); 
}

echo "<form action='dev_edit_questions.php' method='POST'>"; // submit page on itself


echo"<h1>Edit Questions</h1>

     Add or Delete Questions<br/>
     <input type = 'text' name = 'question' value = ''/></br>";
     if(isset($error_msg) && $error_msg) {
    	echo "<p style=\"color: red;\">*".noHTML($error_msg)."</p>";
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

while ($row = $stmt->fetch()){ //fetch array
    echo "<tr>
            <td align='center' bgcolor='#FFFFFF'><input type='checkbox' name='checkbox[]' value='".noHTML($question)."'></td>
            <td bgcolor='#FFFFFF'>" . noHTML($row['question']) . " </td>
         </tr>";
}

echo "</table>";
?>
</br>
<tr>
<td colspan="5" align="center"><input name="update" type="submit" id="Delete" value="Update" action="POST"></td><br/>
</tr>

<br><a href="dev_private.php">Go Back</a><br/>
</form>

</body>