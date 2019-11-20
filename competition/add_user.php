<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        $name=$_POST['name'];
        $pwd=$_POST['pwd'];

        if(empty($name)){
            $errMSG = "�̸��� �Է��ϼ���.";
        }
        else if(empty($pwd)){
            $errMSG = "��й�ȣ�� �Է��ϼ���.";
        }

        if(!isset($errMSG))
        {
            try{         
                $stmt = $con->prepare('INSERT INTO user(name, country) VALUES(:name, :pwd)');
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':pwd', $pwd);

                if($stmt->execute())
                {
                    $successMSG = "���ο� ����ڸ� �߰��߽��ϴ�.";
                }
                else
                {
                    $errMSG = "����� �߰� ����";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
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
                Name: <input type = "text" name = "name" />
                Pwd: <input type = "text" name = "pwd" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>