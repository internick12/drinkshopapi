<?php
   require_once 'db_functions.php';
   $db = new DB_Functions();

   $response = array();

   if(isset($_POST['menuId'])) {

      $menuId = $_POST['menuId'];

      $drinks = $db->getDrinkByMenuID($menuId);
      echo json_encode($drinks);
      
   } else {
        $response["error_msg"] = "Required parameter (menuId) is missing!";
        echo json_encode($response);
  }
?>

