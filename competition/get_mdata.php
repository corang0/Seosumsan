<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
	$group = isset($_POST['group']) ? $_POST['group'] : '';
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        
	$sql="select * from mountain where grp='$group'";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
			
			$sql2="select source from mimage where mid=$id";
			$stmt2 = $con->prepare($sql2);
			$stmt2->execute();
			
			$row2=$stmt2->fetch(PDO::FETCH_ASSOC);
			extract($row2);
    
            array_push($data, 
                array('id'=>$id,
                'name'=>$name,
                'image'=>base64_encode($source)
            ));
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("mountain"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }

?>