<?php 
	require_once("keys.php");
	//Checked by Sam. Status: Good.

	// Initializes session. Sessions stores information on visitor. 
    // Unlike cookie, information stored on server-side, cannot be modified by visitor.
    // some cases, vistor must have cookies enabled
    session_start();

	// tells web browser content is encoded with UTF-8 submit content back with UTF-8 
    header('Content-Type: text/html; charset=utf-8');
     
    

    // MySQL server communicate with $options array using UTF-8 
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
     
    // try/catch statement: error handling 
    // PHP executes within try block.  If error, stops, jumps to catch block. 
    try 
    { 
        // opens connection to DB using PDO library 
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
        // If error occurs while opening connection to DB, error trapped here.will. 
	// output an error. stop executing. 
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
     
    // configures PDO to throw exception when encounters errors. 
    // allows to use try/catch blocks to trap DB errors. 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
     
    // configures PDO to return database rows from DB using associative array 
    // array will have string indexes, string value represents the name of the column in your database. 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
    // undo magic quotes
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 

    // good practice to NOT end PHP files with closing PHP tag. 
    // prevents trailing newlines on the file from being included in output, 
    // can cause problems with redirecting users.