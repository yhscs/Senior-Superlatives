<?php 
	//checked by sam. Status: Good.
    require("common.php"); 
     
	function noHTML($input, $encoding = 'UTF-8'){
		return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding, false);
	}

    // re-display user's username if entered wrong password  
    $submitted_username = ''; 
     
    if(!empty($_POST)) 
    { 
        // query retreives user's information from DB using username. 
        $query = "SELECT id, username, password, salt, email, admin_rights FROM users WHERE username = :username"; 
         
        // parameters 
        $query_params = array(':username' => $_POST['username']); 
         
        try 
        { 
            // Execute query against DB
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // initialize to false, true if successful login
        $login_ok = false; 
         
        // Retrieve user data from DB. If $row is false, then username entered is not registered. 
        $row = $stmt->fetch(); 
        if($row) 
        { 
            
			if($row["password"][0] != "$"){ //old password type
				
				$check_password = hash('sha256', $_POST['password'] . $row['salt']); 
				for($round = 0; $round < 65536; $round++)
				{ 
					$check_password = hash('sha256', $check_password . $row['salt']); 
				} 

				if(hash_equals($check_password, $row['password'])) 
				{ 
					// If match 
					$login_ok = true; 
					
					//update password in DB
					$newHash = password_hash($_POST['password'], PASSWORD_BCRYPT, ["cost" => 12]);
					
					$query = "UPDATE `users` SET `password`= ?, `Salt` = '' WHERE `username` = ?;"; 
					$query_params = array($newHash, $_POST['username']); 
					try 
					{ 
						$stmt = $db->prepare($query); 
						$result = $stmt->execute($query_params); 
					} 
					catch(PDOException $ex) 
					{ 
						die("Failed to run query: " . $ex->getMessage()); 
					} 
				}
				
			} else{ //new passworld type
				if(password_verify($_POST["password"], $row['password'])){
					$login_ok = true;
				}
			}	     
        } 
         
        // user logged in successfully, sent to private members-only page 
        // else, display login failed message, show login form 
        if($login_ok) 
        { 
            // store $row array into $_SESSION by removing salt and password values
	    // Although $_SESSION is stored on server-side, no reason to store sensitive values unless necessary  
            unset($row['salt']); 
            unset($row['password']); 
             
            // stores user's data into session at the index 'user'. 
            // check index on private.php to determine log in status/ user's details 
            $_SESSION['user'] = $row; 
			$_SESSION["username"] = $_POST["username"];
            if($row['admin_rights'] === "1"){
				header("Location: dev_private.php");  
				die("Redirecting to: dev_private.php"); 
            }
			else{
				header("Location: dev_questions.php");  
				die("Redirecting to: dev_questions.php"); 
				}
        } 
        else 
        { 
            // notify user fail 
            print("Login Failed."); 
             
            
            $submitted_username = $_POST['username']; 
        } 
    } 
     
?> 
<style>
body {
    background-color: darkred;
}
.center {
    margin: auto;
    width: 60%;
    border: 3px solid #000000;
    padding: 70px;
}
.right {
    position: absolute;
    right: 0px;
    width: 100px;
    padding: 10px;
}
</style>
<form action="index.php" method="post"> 
<div class="right"><img src="img/Picture4.jpg" alt="Edit Questions" width="75" height="50" border="0"></div>
<div class="center">
 <?php if($_SESSION["voted"]){echo "<p>You have already voted</p>";} ?>
  <h1 style="color:#FFFFFF" >YHS Senior Superlatives</h1> 
    <p style="color:#FFFFFF">Username:</p>
    <input type="text" name="username" value="<?php echo noHTML($submitted_username); ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required /> 
    <br /><br/> 
    <p style="color:#FFFFFF">Password:</p> 
    <input type="password" name="password" value="" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required /> 
    <br /><br/> 
    <input type="submit" value="Login" /> 
    
    <p><a href="dev_register.php">Register to Login</a></p>
    <div>
       <p>Designed and Developed by Darian Mach, Class of 2016<br>
       Security Analysis by Sam Ellertson, Class of 2017</p>
    </div>

</div>

</form> 

