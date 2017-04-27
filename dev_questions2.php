<?php
	//Checked by sam. Status: Good
	require("common.php");
	
	function noHTML($input, $encoding = 'UTF-8')
	{
		return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding, false);
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
    if(empty($_SESSION['user']) || $row['user']['admin_rights'] == "0"){ 
        // If logged out redirect to login page. 
        header("Location: index.php"); 
         
        // users can view private.php content without logging in without die statement 
        die("Redirecting to index.php"); 
    }
	
	$query = "SELECT * FROM questions"; 
	try {  
		$stmt = $db->prepare($query); 
		$stmt->execute();
	} 
	catch(PDOException $ex) {
		die("Failed to run query: " . $ex->getMessage()); 
	}
	
	$questions = $stmt->fetchAll();
	
	foreach ($questions as $question)
	{
		echo '<p>'.noHTML($question['question']).'</p><ol>';
		
		$query = "select id, count(*) AS Total from votes WHERE category = ? group by id order by Total DESC LIMIT 5"; 
		try {  
			$stmt = $db->prepare($query); 
			$stmt->execute(array($question['id']));
		} 
		catch(PDOException $ex) {
			die("Failed to run query: " . $ex->getMessage()); 
		}
		
		$students = $stmt->fetchAll();
		foreach ($students as $student) 
		{
			$query = "select name from STUDENT$ WHERE ID = ? LIMIT 1"; 
			try {  
				$stmt = $db->prepare($query); 
				$stmt->execute(array($student['id']));
			} 
			catch(PDOException $ex) {
				die("Failed to run query: " . $ex->getMessage()); 
			}
			$name = $stmt->fetch()['name'];
			
			echo '<li>'.noHTML($name).': '.noHTML($student['Total']).' votes</li>';
		}
		echo '</ol>';
			
	}

?>