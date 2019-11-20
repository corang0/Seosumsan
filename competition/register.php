<?php

	error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {      	
		$id=$_POST['id'];
		$name=$_POST['name'];
		$pwd=$_POST['password'];

        if(empty($id)){
            $errMSG = "1";
        }
		else if(empty($name)){
            $errMSG = "1";
        }
        else if(empty($pwd)){
            $errMSG = "1";
        }
		
		if(!isset($errMSG)){
			try{
                $stmt = $con->prepare('INSERT INTO user(id, name, pwd) VALUES(:id, :name, :pwd)');
				$stmt->bindParam(':id', $id);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':pwd', $pwd);

                if($stmt->execute())
                {
                    $successMSG = "0";
                }
                else
                {
                    $errMSG = "2";
                }

            } catch(PDOException $e) {
                die($errMSG = "3"); 
            }
        }
    }
	
?>

<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                Id: <input type = "text" name = "id" />
				Name: <input type = "text" name = "name" />
                Password: <input type = "text" name = "password" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>