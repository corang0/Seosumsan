<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        
	$sql="select * from path where id='$id'";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
    
            array_push($data, 
                array('image'=>base64_encode($image)
            ));
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("mountain"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }

?>