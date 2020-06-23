<?php
    session_start();
    extract($_GET);
    if(isset($_SESSION['admin']))
    {
        $user=$_SESSION['admin'][0];
        $userid=$_SESSION['admin'][1];
    }    


    $uploadDirectory = 'assets/images/pic/category/'.$t.'/';

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
    $uploadPath =$uploadDirectory . $n.'.'.$fileExtension; 

    echo $uploadPath;

    if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 2000000) {
            $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                try {
                        require("connection.php");
                        $pic = $n.'.'.$fileExtension;
                        $sql = "UPDATE dish
                        SET pic ='$pic'
                        WHERE name ='$n';";

                        $update = $db->exec($sql);

                }

                catch(PDOException $e)
                    {
                        echo "Connection failed: " . $e->getMessage();
                    }

            } else {
                echo "An error occurred somewhere. Try again or contact the admin";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
            }
        }
    }


    header('location: adminview.php?v=d');

?>