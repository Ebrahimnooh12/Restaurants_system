<?php
    session_start();
    if(isset($_SESSION['activeuser']))
    {
        $user=$_SESSION['activeuser'][0];
        $userid=$_SESSION['activeuser'][1];
    }    

    $uploadDirectory = "assets/images/userpic/";

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
    $uploadPath =$uploadDirectory . $userid.'.'.$fileExtension; 

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
                        $pic = $userid.'.'.$fileExtension;
                        $sql = "UPDATE customer
                        SET profile_pic ='$pic'
                        WHERE cid ='$userid';";

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


    header('location: myaccount.php');

?>