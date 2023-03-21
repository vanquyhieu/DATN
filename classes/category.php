<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
	/**
	* 
	*/
	class category
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function insert_category($Tendanhmuc){
			$Tendanhmuc	 = $this->fm->validation($Tendanhmuc); //gọi ham validation từ file Format để ktra
			$Tendanhmuc = mysqli_real_escape_string($this->db->link, $Tendanhmuc);
			 //mysqli gọi 2 biến. (Tendanhmuc and link) biến link -> gọi conect db từ file db
			
			if(empty($Tendanhmuc)){
				$alert = "<span class='error'>Category must be not empty</span>";
				return $alert;
			}else{
				$query = "INSERT INTO tbl_danhmuc(Tendanhmuc) VALUES('$Tendanhmuc') ";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Insert Category Successfully</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Insert Category NOT Success</span>";
					return $alert;
				}
			}
		}
		public function show_category()
		{
			$query = "SELECT * FROM tbl_danhmuc order by Madanhmuc desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_category($Tendanhmuc,$Madanhmuc)
		{
			$Tendanhmuc = $this->fm->validation($Tendanhmuc); //gọi ham validation từ file Format để ktra
			$Tendanhmuc = mysqli_real_escape_string($this->db->link, $Tendanhmuc);
			$Madanhmuc = mysqli_real_escape_string($this->db->link, $Madanhmuc);
			if(empty($Tendanhmuc)){
				$alert = "<span class='error'>Category must be not empty</span>";
				return $alert;
			}else{
				$query = "UPDATE tbl_danhmuc SET Tendanhmuc= '$Tendanhmuc' WHERE Madanhmuc = '$Madanhmuc' ";
				$result = $this->db->update($query);
				if($result){
					$alert = "<span class='success'>Category Update Successfully</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Update Category NOT Success</span>";
					return $alert;
				}
			}

		}
		public function del_category($Madanhmuc)
		{
			$query = "DELETE FROM tbl_danhmuc where Madanhmuc = '$Madanhmuc' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Category Deleted Successfully</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Category Deleted Not Success</span>";
				return $alert;
			}
		}
		public function getcatbyId($Madanhmuc)
		{
			$query = "SELECT * FROM tbl_danhmuc where Madanhmuc = '$Madanhmuc' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_category_fontend()
		{
			$query = "SELECT * FROM tbl_danhmuc order by Madanhmuc desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_product_by_cat($Madanhmuc)
		{
			$query = "SELECT * FROM tbl_sanpham where Madanhmuc = '$Madanhmuc' order by Madanhmuc desc LIMIT 8";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_name_by_cat($Madanhmuc)
		{
			$query = "SELECT tbl_sanpham.*,tbl_danhmuc.Tendanhmuc,tbl_danhmuc.Madanhmuc 
					  FROM tbl_sanpham,tbl_danhmuc 
					  WHERE tbl_sanpham.Madanhmuc = tbl_danhmuc.Madanhmuc
					  AND tbl_sanpham.Madanhmuc ='$Madanhmuc' LIMIT 1 ";
			$result = $this->db->select($query);
			return $result;
		}
	}
 ?>