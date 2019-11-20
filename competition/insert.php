<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    if( ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit']))
    {

        $name=$_POST['name'];
		$grp=$_POST['grp'];
		$info=$_POST['info'];
		$address=$_POST['address'];
        $height=$_POST['height'];
		$directions=$_POST['directions'];

        if(empty($name)){
            $errMSG = "ºóÄ­À» ÀÔ·ÂÇÏ¼¼¿ä.";
        }
        else if(empty($grp)){
            $errMSG = "ºóÄ­À» ÀÔ·ÂÇÏ¼¼¿ä.";
        }
		else if(empty($info)){
            $errMSG = "ºóÄ­À» ÀÔ·ÂÇÏ¼¼¿ä.";
        }
		else if(empty($address)){
            $errMSG = "ºóÄ­À» ÀÔ·ÂÇÏ¼¼¿ä.";
        }
		else if(empty($height)){
            $errMSG = "ºóÄ­À» ÀÔ·ÂÇÏ¼¼¿ä.";
        }
		else if(empty($directions)){
            $errMSG = "ºóÄ­À» ÀÔ·ÂÇÏ¼¼¿ä.";
        }

        if(!isset($errMSG))
        {
            try{
                $stmt = $con->prepare('INSERT INTO mountain(name, grp, info, address, height, directions) VALUES(:name, :grp, :info, :address, :height, :directions)');
                $stmt->bindParam(':name', $name);
				$stmt->bindParam(':grp', $grp);
				$stmt->bindParam(':info', $info);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':height', $height);
                $stmt->bindParam(':directions', $directions);

                if($stmt->execute())
                {
                    $successMSG = "Data added.";
                }
                else
                {
                    $errMSG = "Failed";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }
?>

<html>
   <body>
        <?php 
        if (isset($errMSG)) echo $errMSG;
        if (isset($successMSG)) echo $successMSG;
        ?>
        
        <form action="<?php $_PHP_SELF ?>" method="POST">
            Name: <input type = "text" name = "name" /><br>
			Group: <input type = "text" name = "grp" /><br>
			Info: <input type = "text" name = "info" /><br>
			Address: <input type = "text" name = "address" /><br>
			Height: <input type = "text" name = "height" /><br>
            Directions: <input type = "text" name = "directions" /><br>
            <input type = "submit" name = "submit" />
        </form>
   
   </body>
</html>