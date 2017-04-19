<?php 

    require("common.php"); 
     
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
            // Uses password input and salt stored, hash submitted password and compare to hashed version in DB 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++)
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
                // If match 
                $login_ok = true; 
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
             
            // Show username again, enter new password
            // htmlentities prevents XSS attacks. use htmlentities on user submitted values 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
     
?> 

<form action="index.php" method="post"> 
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
<div class="right"><img src="/img/Picture4.jpg" alt="Edit Questions" width="75" height="50" border="0"></div>
<div class="center">
  <h1 style="color:#FFFFFF" >YHS Senior Superlatives</h1> 
    <p style="color:#FFFFFF">Username:</p>
    <input type="text" name="username" value="<?php echo $submitted_username; ?>" /> 
    <br /><br/> 
    <p style="color:#FFFFFF">Password:</p> 
    <input type="password" name="password" value=""/> 
    <br /><br/> 
    <input type="submit" value="Login" /> 
    
    <p><a href="dev_register.php">Register to Login</a></p>
    <div class="footer">
       <p>Designed and Developed by Darian Mach, Class of 2016</p>
    </div>

</div>

</form> 

