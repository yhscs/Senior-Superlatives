<?php
//Checked by Sam. Status: Good.
session_start();
session_destroy();
header('Location: index.php');
exit();
?>