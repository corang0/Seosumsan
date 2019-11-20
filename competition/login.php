<?php

	error_reporting(E_ALL); 
    ini_set('display_errors',1); 

	include('dbcon.php');
	
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$pwd = isset($_POST['password']) ? $_POST['password'] : '';
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        
	$sql="select * from user where id='$id' and pwd='$pwd'";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        echo $id;
    }
	
?>