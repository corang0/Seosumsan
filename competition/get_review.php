<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
	$uid = isset($_POST['uid']) ? $_POST['uid'] : '';
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        
	$sql="select * from review where uid='$uid'";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
			
			$sql2="select name from mountain where id=$mid";
			$stmt2 = $con->prepare($sql2);
			$stmt2->execute();	
			
			$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
			extract($row2);
    
            array_push($data, 
                array('name'=>$name,
                'content'=>$content,
                'rating'=>$rating
            ));
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("mountain"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }

?>