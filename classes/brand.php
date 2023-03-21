<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>



<?php 
	/**
	* 
	*/
	class brand
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_brand($Tenthuonghieu){
			$Tenthuonghieu = $this->fm->validation($Tenthuonghieu); //gọi ham validation để ktra có rỗng hay ko để ktra
			$Tenthuonghieu = mysqli_real_escape_string($this->db->link, $Tenthuonghieu);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
			
			if(empty($Tenthuonghieu)){
				$alert = "<span class='error'>Brand must be not empty</span>";
				return $alert;
			}else{
				$query = "INSERT INTO tbl_thuonghieu(Tenthuonghieu) VALUES('$Tenthuonghieu') ";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Insert brand Successfully</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Insert brand NOT Success</span>";
					return $alert;
				}
			}
		}
		public function show_brand()
		{
			$query = "SELECT * FROM tbl_thuonghieu order by Mathuonghieu desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getbrandbyId($Mathuonghieu)
		{
			$query = "SELECT * FROM tbl_thuonghieu where Mathuonghieu = '$Mathuonghieu' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_brand($Tenthuonghieu,$Mathuonghieu)
		{
			$Tenthuonghieu = $this->fm->validation($Tenthuonghieu); //gọi ham validation từ file Format để ktra
			$Tenthuonghieu = mysqli_real_escape_string($this->db->link, $Tenthuonghieu);
			$Mathuonghieu = mysqli_real_escape_string($this->db->link, $Mathuonghieu);
			if(empty($Tenthuonghieu)){
				$alert = "<span class='error'>Brand must be not empty</span>";
				return $alert;
			}else{
				$query = "UPDATE tbl_thuonghieu SET Tenthuonghieu= '$Tenthuonghieu' WHERE Mathuonghieu = '$Mathuonghieu' ";
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='success'>Brand Update Successfully</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Update Brand NOT Success</span>";
					return $alert;
				}
			}

		}
		public function del_brand($Mathuonghieu)
		{
			$query = "DELETE FROM tbl_thuonghieu where Mathuonghieu = '$Mathuonghieu' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Brand Deleted Successfully</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Brand Deleted Not Success</span>";
				return $alert;
			}
		}
		
	}
 ?>