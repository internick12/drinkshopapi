<?php
   require_once 'db_functions.php';
   $db = new DB_Functions();

   if(isset($_FILES["uploaded_file"]["name"])) {
      if(isset($_POST["phone"])) {
          $phone = $_POST["phone"];
          $name = $_FILES["uploaded_file"]["name"];
          $tmp_name = $_FILES["uploaded_file"]["tmp_name"];
          $error = $_FILES["uploaded_file"]["error"];

          if(!empty($name)) {

            $location = './user_avatar/';
            if(!is_dir($location))
                mkdir($location);
            
            if(move_uploaded_file($tmp_name, $location . $name)) {

                $result = $db->updateAvatar($phone, $name);
                           
                if($result)
                  echo json_encode("uploaded...");
                else
                  echo json_encode("Error while wirite database");
                
            }

          }

      } else
        json_encode("Phone missing");

   } else 
    json_encode("Please select file...");
?>

















