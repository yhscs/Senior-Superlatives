<?php 
	//checked by Sam. Status: Good.
    require("common.php"); 

	function noHTML($input, $encoding = 'UTF-8')
	{
		return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding, false);
	}

    // check user login status 
    if(empty($_SESSION['user']))  
    { 
	// logged out, redirect to login.php 
        header("Location: login.php"); 

	// die statement 
        die("Redirecting to login.php"); 
    } 
    
//BEGIN ADMIN CHECK
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
//END ADMIN CHECK

    // if edit form has been submitted, display form 
    // false, then run account update 
    if(!empty($_POST))
    { 
	// valid E-Mail address 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
        
	// new input E-Mail doesn't conflict with current value 
        // If no change by user, no check needed.  
        if($_POST['email'] != $_SESSION['user']['email']) 
        { 
	    // Define our SQL query
            $query = "SELECT 1 FROM users WHERE email = :email"; 

            // Define our query parameter values     
            $query_params = array(':email' => $_POST['email']); 
             
            try 
            { 
		// Execute query 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex) 
            { 
		// no $ex->getMessage(). 
                die("Failed to run query: " . $ex->getMessage()); 
            } 

            // Retrieve results (if any) 
            $row = $stmt->fetch(); 
            if($row) 
            { 
                die("This E-Mail address is already in use"); 
            } 
        }
 
       	// If user change password, hash new pass, generate seperate new salt.    
        if(!empty($_POST['password'])) 
        {    
			$password = password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 12]);
        } 
        else 
        { 
	    // If no new password input, keep current 
            $password = null; 
            $salt = null; 
        }
 
        // Initial query parameter values   
        $query_params = array(':email' => $_POST['email'],':user_id' => $_SESSION['user']['id']); 
        
	// If password change, set parameter values for new password hash  
        if($password !== null) 
        { 
            $query_params[':password'] = $password; 
        } 
          
        $query = "UPDATE users SET email = :email"; 
        
	// If password change, extend SQL query to include password/salt columns and parameters   
        if($password !== null) 
        { 
            $query .= ", password = :password"; 
        } 

        // specify to update only the one record for current user. 
        $query .= " WHERE id = :user_id"; 
         
        try 
        {
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 

        $_SESSION['user']['email'] = $_POST['email'];
         
        header("Location: dev_private.php"); 
         
        die("Redirecting to dev_private.php"); 
    } 
     
?> 
<h1>Edit Account</h1> 
<form action="dev_edit_account.php" method="post"> 
    Username:<br /> 
    <b><?php echo noHTML($_SESSION['user']['username']); ?></b> 
    <br /><br /> 
    E-Mail Address:<br /> 
    <input type="text" name="email" value="<?php echo noHTML($_SESSION['user']['email']); ?>" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /><br /> 
    <i>(leave blank if you do not want to change your password)</i> 
    <br /><br /> 
    <input type="submit" value="Update Account" /> 
</form>