<?php 
    // execute common code
    // connect to database & start the session 
    require("common.php"); 
     
    // checks to determine whether registration form been submitted 
    // If true, run registration code , else display form 
    if(!empty($_POST)) 
    { 
        // Ensure that the user has entered a non-empty username 
        if(empty($_POST['username'])) 
        { 
            // do not use die() to handle user errors  Display error with form for user to correct
	    //im being a hypocrite
            die("Please enter a username."); 
        } 
         
        // non-empty password 
        if(empty($_POST['password'])) 
        { 
            die("Please enter a password."); 
        } 
         
        // valid E-Mail address 
        // filter_var PHP function to validate form input 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        {   
           $email = "";
        } 
         
        // SQL query to see if username is already in use. SELECT query retrieves data from DB. 
        // :username substitute real value in its place when execute query 
        $query = "SELECT 1 FROM users  WHERE username = :username"; 
         
        // contains definitions for special tokens in SQL query, defines value for the token:username.  
	// not recomended to insert $_POST['username'] directly into $query string;
	// insecure and opens your code up to SQL injection exploits.  Using tokens prevents this. 
        $query_params = array(':username' => $_POST['username']); 
         
        try 
        { 
            // run the query against DB table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // should not output $ex->getMessage(). 
            // may provide attacker with info, im the best hypocrite  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // fetch() method returns array representing "next" row from selected results
	// false if there no more rows to fetch. 
        $row = $stmt->fetch(); 
         
        // if row returned, matching username was found in DB, should not allow user to continue. 
        if($row) 
        { 
            die("This username is already in use"); 
        } 
         
        // perform the same check for email, ensure uniqueness
        $query = "SELECT 1 FROM users WHERE email = :email"; 
         
        $query_params = array(':email' => $_POST['email']); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
         
        // INSERT query used to add new rows to DB table. 
        // parameters to protect against SQL injection attacks. 
        $query = "INSERT INTO users (username, password, salt, email) VALUES ( :username, :password, :salt, :email)"; 
         
        // salt randomly generated
	// protects against brute force/ rainbow table attacks 
        // statement generates hex representation of 8 byte salt. hex no additional security, humans easier to read 
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
         
        // hashes password with salt sercure in DB
	// output is 64 byte hex string representing the 32 byte sha256 hash of password. 
	// original password unrecoverable from hash 
        $password = hash('sha256', $_POST['password'] . $salt); 
         
        // loop 65536 more times. Protect against brute force 
	// attacker must compute the hash 65537 for each guess
        for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
 
        // insertion into SQL query. Do not store password as plaintext but hash version. 
        // Salt in plaintext is not sercurity risk
        $query_params = array(':username' => $_POST['username'], ':password' => $password, ':salt' => $salt, ':email' => $_POST['email']); 
         
        try 
        { 
            // Execute the query to create the user 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        {   
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // redirects user back to login page after register 
        header("Location: index.php"); 
         
        // must call die/exit after performing redirect: use header function 
        // rest of PHP script will continue to execute. sent to the user if not die or exit 
        die("Redirecting to index.php"); 
    }
     
?> 
<h1>Add User</h1> 
<form action="dev_register.php" method="post"> 
    Username:<br/> 
    <input type="text" name="username" value=""/> 
    <br/><br/> 
    E-Mail:<br/> 
    <input type="text" name="email" value=""/> 
    <br/><br/> 
    Password:<br/> 
    <input type="password" name="password" value=""/>
    <br/><br/> 
    <input type="submit" value="Register"/> 
</form>