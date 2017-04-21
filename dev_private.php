<?php 
    require("common.php");

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
    if(empty($_SESSION['user']) || $row['user']['admin_rights'] === 0) 
    { 
        // If logged out redirect to login page. 
        header("Location: index.php"); 
         
        // users can view private.php content without logging in without die statement 
        die("Redirecting to index.php"); 
    }

?> 
<form> 

<style>
.right {
    position: absolute;
    right: 0px;
    width: 100px;
    padding: 10px;
}
</style>
<div class="right"><img src="/img/Picture4.jpg" alt="Edit Questions" width="75" height="50" border="0"></div>
<h3>Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?> Admin Panel</h3><br/>

<a href="dev_register.php">Add User</a><br/> 
<a href="dev_alt_memberlist.php">Student/User List</a><br/> 
<a href="dev_edit_account.php">Edit Account</a><br/> <br/>   
<a href="dev_edit_questions.php">
<img src="/img/Picture1.png" alt="Edit Questions" width="100" height="100" border="0">
</a><a href="dev_questions2.php">
<img src="/img/Picture2.png" alt="Results" width="100" height="100" border="0">
</a>
<a href="dev_logout.php"><img src="/img/Picture3.png" alt="Logout" width="100" height="100" border="0">
</a>   
<pre>Edit Questions  View Results     Logout</pre>
</form> 