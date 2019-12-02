<?php

class DB_Functions {

   private $conn;

   function __construct() {
    require_once 'db_connect.php';
    $db = new DB_Connect();
    $this->conn = $db->connect();
   
   }

   function __destruct() {
   }

   function checkExistsUser($phone) {
    $stmt = $this->conn->prepare("SELECT * FROM User WHERE Phone=?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    
    if($stmt->num_rows > 0) {
     $stmt->close();
     return true;
    } else {
     $stmt->close();
     return false;
    }
   }

   public function registerNewUser($phone, $name, $birthdate, $address) {
    $stmt = $this->conn->prepare("INSERT INTO User(Phone, Name, Birthdate, Address) VALUES(?,?,?,?)");
    $stmt->bind_param("ssss", $phone, $name, $birthdate, $address);
    $result = $stmt->execute();
    $stmt->close();

    if($result) {
      $stmt = $this->conn->prepare("SELECT * FROM User WHERE Phone = ?");
      $stmt->bind_param("s", $phone);
      $stmt->execute();
      $user = $stmt->get_result()->fetch_assoc();
      $stmt->close();
      return $user;
    } else {
      return false;
    }
  }


  public function getUserInformation($phone) {
  	$stmt = $this->conn->prepare("SELECT * FROM User WHERE Phone=?");
  	$stmt->bind_param("s", $phone);

  	if($stmt->execute()) {
  		$user = $stmt->get_result()->fetch_assoc();
  		$stmt->close();
  		return $user;
  	} else {
  		return NULL;
  	}
  }

  public function getBanners() {
      $result = $this->conn->query("SELECT * FROM banner ORDER BY ID LIMIT 3");
      $banners = array();

      while($item = $result->fetch_assoc())
        $banners[] = $item;
      return $banners;
  }

  public function getMenu() {
      $result = $this->conn->query("SELECT * FROM menu");
      $menu = array();

      while($item = $result->fetch_assoc())
        $menu[] = $item;
      return $menu;
  }

  public function getDrinkByMenuID($menuId) {
    $query = "SELECT * FROM drink WHERE MenuId='".$menuId."'";
      $result = $this->conn->query($query);
      $drinks = array();

      while($item = $result->fetch_assoc())
        $drinks[] = $item;
      return $drinks;
  }

  public function updateAvatar($phone, $fileName) {
  
    return $result = $this->conn->query("UPDATE User SET avatarUrl='".$fileName."' WHERE Phone='".$phone."'");  

  }

  public function getAllDrinks() {
    $result = $this->conn->query("SELECT * FROM drink WHERE 1") or die ($this->conn->error);
    $drinks = array();
    while($item = $result->fetch_assoc())
      $drinks[] = $item;
    return $drinks;  
  }

  public function insertNewOrder($orderPrice, $orderComment, $orderAddress, $orderDetail, $userPhone){
    $stmt = $this->conn->prepare("INSERT INTO `Order`(`OrderStatus`, `OrderPrice`, `OrderDetail`, `OrderComment`, `OrderAddress`, `UserPhone`) VALUES (0,?,?,?,?,?)") 
           or die($this->conn->error);
    $stmt->bind_param("sssss", $orderPrice, $orderDetail, $orderComment, $orderAddress, $userPhone);
    $result = $stmt->execute();
    $stmt->close();

    if($result)
      return true;
    else
      return false;  
  }

}
?>















































