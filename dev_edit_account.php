<?php 

    require("common.php"); 

    // check user login status 
    if(empty($_SESSION['user']))  
    { 
	// logged out, redirect to login.php 
        header("Location: login.php"); 

	// die statement 
        die("Redirecting to login.php"); 
    } 
    
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
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
            $password = hash('sha256', $_POST['password'] . $salt); 
            for($round = 0; $round < 65536; $round++)
            { 
                $password = hash('sha256', $password . $salt); 
            } 
        } 
        else 
        { 
	    // If no new password input, keep current 
            $password = null; 
            $salt = null; 
        }
 
        // Initial query parameter values   
        $query_params = array(':email' => $_POST['email'],':user_id' => $_SESSION['user']['id']); 
        
	// If password change, set parameter values for new password hash/salt   
        if($password !== null) 
        { 
            $query_params[':password'] = $password; 
            $query_params[':salt'] = $salt; 
        } 
          
        $query = "UPDATE users SET email = :email"; 
        
	// If password change, extend SQL query to include password/salt columns and parameters   
        if($password !== null) 
        { 
            $query .= ", password = :password , salt = :salt"; 
        } 

        // specify to update only the one record for current user. 
        $query .= " 
            WHERE 
                id = :user_id
        "; 
         
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
    <b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b> 
    <br /><br /> 
    E-Mail Address:<br /> 
    <input type="text" name="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /><br /> 
    <i>(leave blank if you do not want to change your password)</i> 
    <br /><br /> 
    <input type="submit" value="Update Account" /> 
</form>