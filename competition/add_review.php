<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        $uid=$_POST['uid'];
		$sql="select * from user where id='$uid'";
		$stmt = $con->prepare($sql);
		$stmt->execute();

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
		}
		
		$content=$_POST['content'];
		$rating=$_POST['rating'];
		$mid=$_POST['mid'];

        try{         
            $stmt = $con->prepare('INSERT INTO review(name, content, rating, uid, mid) VALUES(:name, :content, :rating, :uid, :mid)');
            $stmt->bindParam(':name', $name);
			$stmt->bindParam(':content', $content);
            $stmt->bindParam(':rating', $rating);
			$stmt->bindParam(':uid', $uid);
			$stmt->bindParam(':mid', $mid);

            $stmt->execute();
			echo $name;
        } catch(PDOException $e) {
            die("Database error: " . $e->getMessage()); 
        }
    }

?>


<?php 
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                Name: <input type = "text" name = "name" />
                Pwd: <input type = "text" name = "pwd" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>