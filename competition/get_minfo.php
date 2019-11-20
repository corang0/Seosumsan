<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
	$mid = isset($_POST['mid']) ? $_POST['mid'] : '';
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
        
	$sql="select * from mountain where id='$mid'";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
			
			$sql2="select source from mimage where mid=$mid";
			$stmt2 = $con->prepare($sql2);
			$stmt2->execute();
			
			$images = array(); 			
			
			while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
			{
				extract($row2);
				
				array_push($images,
					array('image'=>base64_encode($source)
				));
			}
			
			$sql3="select * from sights where mid=$mid";
			$stmt3 = $con->prepare($sql3);
			$stmt3->execute();
			
			$sights = array(); 			
			
			while($row3=$stmt3->fetch(PDO::FETCH_ASSOC))
			{
				extract($row3);
				
				array_push($sights,
					array('name'=>$name,
					'image'=>base64_encode($image)
				));
			}
			
			$sql4="select * from review where mid=$mid";
			$stmt4 = $con->prepare($sql4);
			$stmt4->execute();
			
			$review = array(); 			
			
			while($row4=$stmt4->fetch(PDO::FETCH_ASSOC))
			{
				extract($row4);
				
				array_push($review,
					array('name'=>$name,
					'content'=>$content,
					'rating'=>$rating
				));
			}
			
			$sql5="select * from path where mid=$mid";
			$stmt5 = $con->prepare($sql5);
			$stmt5->execute();
			
			$path = array(); 			
			
			while($row5=$stmt5->fetch(PDO::FETCH_ASSOC))
			{
				extract($row5);
				
				array_push($path,
					array('id'=>$id,
					'name'=>$name,
					'start'=>$start,
					'end'=>$end
				));
			}
			
			$sql6="select * from restaurant where mid=$mid";
			$stmt6 = $con->prepare($sql6);
			$stmt6->execute();
			
			$restaurant = array(); 			
			
			while($row6=$stmt6->fetch(PDO::FETCH_ASSOC))
			{
				extract($row6);
				
				array_push($restaurant,
					array('name'=>$name,
					'image'=>base64_encode($image)
				));
			}
			
			extract($row);
			
            array_push($data, 
                array('name'=>$name,
				'address'=>$address,
				'height'=>$height,
				'directions'=>$directions,
                'info'=>$info,				
                'images'=>$images,
				'sights'=>$sights,
				'review'=>$review,
				'path'=>$path,
				'restaurant'=>$restaurant
            ));
        }

        header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("mountain"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        echo $json;
    }

?>