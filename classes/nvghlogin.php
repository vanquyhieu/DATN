<?php
	$filepath = realpath(dirname(__FILE__));
	include ($filepath.'/../lib/session.php');
	Session::checkLogin(); // gọi hàm check login để ktra session
	include_once($filepath.'/../lib/database.php');
	include_once($filepath.'/../helpers/format.php');
?>



<?php 
	/**
	* 
	*/
	class nvghlogin
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function longin_nvgh($Tendangnhap,$Matkhau){
			$Tendangnhap = $this->fm->validation($Tendangnhap); //gọi ham validation từ file Format để ktra
			$Matkhau = $this->fm->validation($Matkhau);

			$Tendangnhap = mysqli_real_escape_string($this->db->link, $Tendangnhap);
			$Matkhau = mysqli_real_escape_string($this->db->link, $Matkhau); //mysqli gọi 2 biến. (adminUser and link) biến link -> gọi conect db từ file db
			
			if(empty($Tendangnhap) || empty($Matkhau)){
				$alert = "User and Pass không nhập rỗng";
				return $alert;
			}else{
				$query = "SELECT * FROM tbl_nvgh WHERE Tendangnhap = '$Tendangnhap' AND Matkhau = '$Matkhau' LIMIT 1 ";
				$result = $this->db->select($query);

				if($result != false){
					//session_start();
					// $_SESSION['login'] = 1;
					//$_SESSION['user'] = $user;
					$value = $result->fetch_assoc();
					Session::set('adminlogin', true); // set adminlogin đã tồn tại
					// gọi function Checklogin để kiểm tra true.
					Session::set('IdAdmin', $value['IdGH']);
					Session::set('Tendangnhap', $value['Tendangnhap']);
					Session::set('Matkhau', $value['Matkhau']);
					header("Location:index.php");
				}else {
					$alert = "User and Pass not match";
					return $alert;
				}
			}


		}
	}
 ?>