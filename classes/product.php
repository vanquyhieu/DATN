<?php

	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>

<?php 
	/**
	* 
	*/
	class product
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function insert_product($date,$files){
			
			$TenSanpham = mysqli_real_escape_string($this->db->link, $date['TenSanpham']);
			$MaSanpham = mysqli_real_escape_string($this->db->link, $date['MaSanpham']);

			$Soluong = mysqli_real_escape_string($this->db->link, $date['Soluong']);
			$Madanhmuc = mysqli_real_escape_string($this->db->link, $date['Madanhmuc']);
			$Mathuonghieu = mysqli_real_escape_string($this->db->link, $date['Mathuonghieu']);
			$Mota = mysqli_real_escape_string($this->db->link, $date['Mota']);
			$Gia = mysqli_real_escape_string($this->db->link, $date['Gia']);
			$Loai = mysqli_real_escape_string($this->db->link, $date['Loai']);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
			
			// kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
			$permited = array('jpg','jpeg','png','gif');
			$file_name = $_FILES['Hinhanh']['name'];
			$file_size = $_FILES['Hinhanh']['size'];
			$file_temp = $_FILES['Hinhanh']['tmp_name'];
			
			$div =explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(time()), 0,10).'.'.$file_ext;
			$uploaded_image = "uploads/".$unique_image;

			if( $TenSanpham =="" || $MaSanpham == "" || $Soluong == "" || $Madanhmuc == "" || $Mathuonghieu == "" || $Mota == "" || $Gia == "" || $Loai == "" || $file_name == ""){
				$alert = "<span class='error'>Fiedls must be not empty</span>";
				return $alert;
			}else{
				move_uploaded_file($file_temp, $uploaded_image);

				$query = "INSERT INTO tbl_sanpham(TenSanpham,MaSanpham,conlai,Soluong,Madanhmuc,Mathuonghieu,Mota,Gia,Loai,Hinhanh) VALUES('$TenSanpham','$MaSanpham','$Soluong','$Soluong','$Madanhmuc','$Mathuonghieu','$Mota','$Gia','$Loai','$unique_image') ";
				$result = $this->db->insert($query);
				if($result){
					$alert = "<span class='success'>Thêm sản phẩm thành công</span>";
					return $alert;
				}else {
					$alert = "<span class='error'>Thêm sản phẩm thất bại</span>";
					return $alert;
				}
			}
		}
		public function insert_slider($date,$files)
		{
			$TenSlider = mysqli_real_escape_string($this->db->link, $date['TenSlider']);
			$Loai = mysqli_real_escape_string($this->db->link, $date['Loai']);
			 //mysqli gọi 2 biến. (catName and link) biến link -> gọi conect db từ file db
			
			// kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
			$permited  = array('jpg', 'jpeg', 'png', 'gif');

			$file_name = $_FILES['Hinhanh']['name'];
			$file_size = $_FILES['Hinhanh']['size'];
			$file_temp = $_FILES['Hinhanh']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			// $file_current = strtolower(current($div));
			$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
			$uploaded_image = "uploads/".$unique_image;


			if($TenSlider=="" || $Loai==""){
				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert; 
			}else{
				if(!empty($file_name)){
					//Nếu người dùng chọn ảnh
					if ($file_size > 2048000) {

		    		 $alert = "<span class='success'>Image Size should be less then 2MB!</span>";
					return $alert;
				    } 
					elseif (in_array($file_ext, $permited) === false) 
					{
				     // echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";	
				    $alert = "<span class='success'>You can upload only:-".implode(', ', $permited)."</span>";
					return $alert;
					}
					move_uploaded_file($file_temp,$uploaded_image);
					
					$query = "INSERT INTO tbl_slider(TenSlider,Loai,AnhSlider) VALUES('$TenSlider','$Loai','$unique_image') ";
					$result = $this->db->insert($query);
					if($result){
						$alert = "<span class='success'>Slider Added Successfully</span>";
						return $alert;
					}else {
						$alert = "<span class='error'>Slider Added NOT Success</span>";
						return $alert;
					}
				}
				
				
			}

		}
		public function show_slider(){
			$query = "SELECT * FROM tbl_slider where Loai='1' order by sliderId desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_slider_list(){
			$query = "SELECT * FROM tbl_slider order by sliderId desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function show_product_warehouse(){
			$query = 
			"SELECT tbl_sanpham.*, tbl_khohang.*

			 FROM tbl_sanpham INNER JOIN tbl_khohang ON tbl_sanpham.IdSanpham = tbl_khohang.IdSanpham
								
			 order by tbl_khohang.sl_ngaynhap desc ";

		
			$result = $this->db->select($query);
			return $result;
		}
		public function show_product()
		{
			$query = 
			"SELECT tbl_sanpham.*, tbl_danhmuc.Tendanhmuc, tbl_thuonghieu.Tenthuonghieu

			 FROM tbl_sanpham INNER JOIN tbl_danhmuc ON tbl_sanpham.Madanhmuc = tbl_danhmuc.Madanhmuc
								INNER JOIN tbl_thuonghieu ON tbl_sanpham.Mathuonghieu = tbl_thuonghieu.Mathuonghieu
			 order by tbl_sanpham.IdSanpham  desc ";

			// $query = "SELECT * FROM tbl_sanpham order by IdSanpham desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_Loai_slider($id,$Loai){

			$Loai = mysqli_real_escape_string($this->db->link, $Loai);
			$query = "UPDATE tbl_slider SET Loai = '$Loai' where sliderId='$id'";
			$result = $this->db->update($query);
			return $result;
		}
		public function del_slider($id)
		{
			$query = "DELETE FROM tbl_slider where sliderId = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Slider Deleted Successfully</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Slider Deleted Not Success</span>";
				return $alert;
			}
		}
		public function update_quantity_product($data,$files,$id){
			$product_more_quantity = mysqli_real_escape_string($this->db->link, $data['product_more_quantity']);
			$product_remain = mysqli_real_escape_string($this->db->link, $data['product_remain']);
			
			if($product_more_quantity == ""){

				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert; 
			}else{
					$qty_total = $product_more_quantity + $product_remain;
					//Nếu người dùng không chọn ảnh
					$query = "UPDATE tbl_sanpham SET
					
					Conlai = '$qty_total'

					WHERE IdSanpham = '$id'";
					
					}
					$query_warehouse = "INSERT INTO tbl_khohang(IdSanpham,sl_nhap) VALUES('$id','$product_more_quantity') ";
					$result_insert = $this->db->insert($query_warehouse);
					$result = $this->db->update($query);

					if($result){
						$alert = "<span class='success'>Thêm số lượng thành công</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Thêm số lượng không thành công</span>";
						return $alert;
					}
				
		}
		public function update_product($data,$files,$id){
	
			$TenSanpham = mysqli_real_escape_string($this->db->link, $data['TenSanpham']);
			$MaSanpham = mysqli_real_escape_string($this->db->link, $data['MaSanpham']);
			$Soluong = mysqli_real_escape_string($this->db->link, $data['Soluong']);
			$Mathuonghieu = mysqli_real_escape_string($this->db->link, $data['Mathuonghieu']);
			$Madanhmuc = mysqli_real_escape_string($this->db->link, $data['Madanhmuc']);
			$Mota = mysqli_real_escape_string($this->db->link, $data['Mota']);
			$Gia = mysqli_real_escape_string($this->db->link, $data['Gia']);
			$Loai = mysqli_real_escape_string($this->db->link, $data['Loai']);
			//Kiem tra hình ảnh và lấy hình ảnh cho vào folder upload
			$permited  = array('jpg', 'jpeg', 'png', 'gif');

			$file_name = $_FILES['Hinhanh']['name'];
			$file_size = $_FILES['Hinhanh']['size'];
			$file_temp = $_FILES['Hinhanh']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			// $file_current = strtolower(current($div));
			$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
			$uploaded_image = "uploads/".$unique_image;


			if($MaSanpham == "" || $TenSanpham=="" || $Soluong=="" || $Mathuonghieu=="" || $Madanhmuc=="" || $Mota=="" || $Gia=="" || $Loai==""){
				$alert = "<span class='error'>Hình ảnh không được trống</span>";
				return $alert; 
			}else{
				if(!empty($file_name)){
					//Nếu người dùng chọn ảnh
					if ($file_size > 20480) {

		    		 $alert = "<span class='success'>Ảnh dưới 2mb</span>";
					return $alert;
				    } 
					elseif (in_array($file_ext, $permited) === false) 
					{
				     // echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";	
				    $alert = "<span class='success'>Bạn chỉ có thể tải lên:-".implode(', ', $permited)."</span>";
					return $alert;
					}
					move_uploaded_file($file_temp,$uploaded_image);
					$query = "UPDATE tbl_sanpham SET
					TenSanpham = '$TenSanpham',
					MaSanpham = '$MaSanpham',
					Soluong = '$Soluong',
					Mathuonghieu = '$Mathuonghieu',
					Madanhmuc = '$Madanhmuc', 
					Loai = '$Loai', 
					Gia = '$Gia', 
					Hinhanh = '$unique_image',
					Mota = '$Mota'
					WHERE IdSanpham  = '$id'";
					
				}else{
					//Nếu người dùng không chọn ảnh
					$query = "UPDATE tbl_sanpham SET

					TenSanpham = '$TenSanpham',
					MaSanpham = '$MaSanpham',
					Soluong = '$Soluong',
					Mathuonghieu = '$Mathuonghieu',
					Madanhmuc = '$Madanhmuc', 
					Loai = '$Loai', 
					Gia = '$Gia', 
					
					Mota = '$Mota'

					WHERE IdSanpham  = '$id'";
					
				}
				$result = $this->db->update($query);
					if($result){
						$alert = "<span class='success'>Sản phẩm Updated thành công</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Sản phẩm Updated không thành công</span>";
						return $alert;
					}
				
			}

		}
		public function del_product($id)
		{
			$query = "DELETE FROM tbl_sanpham where IdSanpham = '$id' ";
			$result = $this->db->delete($query);
			if($result){
				$alert = "<span class='success'>Xóa thành công</span>";
				return $alert;
			}else {
				$alert = "<span class='success'>Xóa thất bại</span>";
				return $alert;
			}
		}
		public function del_wlist($proid,$customer_id)
		{
			$query = "DELETE FROM tbl_yeuthich where IdSanpham = '$IdSanpham' AND IdKhachhang='$customer_id' ";
			$result = $this->db->delete($query);
			return $result;
		}
		public function getproductbyId($id)
		{
			$query = "SELECT * FROM tbl_sanpham where IdSanpham = '$id' ";
			$result = $this->db->select($query);
			return $result;
		}		
		//Kết thúc Backend

		public function getproduct_featheread()
		{
			$query = "SELECT * FROM tbl_sanpham where Loai = '1' order by IdSanpham desc LIMIT 4 ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getproduct_all()
		{
			$query = "SELECT * FROM tbl_sanpham order by IdSanpham desc ";
			$result = $this->db->select($query);
			return $result;
		}
		public function getproduct_new()
		{
			$query = "SELECT * FROM tbl_sanpham order by IdSanpham desc LIMIT 4 ";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_details($id)
		{
			$query = 
			"SELECT tbl_sanpham.*, tbl_danhmuc.Tendanhmuc, tbl_thuonghieu.Tenthuonghieu

			 FROM tbl_sanpham INNER JOIN tbl_danhmuc ON tbl_sanpham.Madanhmuc = tbl_danhmuc.Madanhmuc
								INNER JOIN tbl_thuonghieu ON tbl_sanpham.Mathuonghieu = tbl_Thuonghieu.Mathuonghieu
			 WHERE tbl_sanpham.IdSanpham  = '$id'
			 ";

			$result = $this->db->select($query);
			return $result;
		}
		public function getLastestDell()
		{
			$query = "SELECT * FROM tbl_sanpham where Mathuonghieu = '10' order by IdSanpham desc limit 1";
			$result = $this->db->select($query);
			return $result;	
		}
		public function getLastestHuawei()
		{
			$query = "SELECT * FROM tbl_sanpham where Mathuonghieu = '9' order by IdSanpham desc limit 1";
			$result = $this->db->select($query);
			return $result;	
		}
		public function getLastestApple()
		{
			$query = "SELECT * FROM tbl_sanpham where Mathuonghieu = '8' order by IdSanpham desc limit 1";
			$result = $this->db->select($query);
			return $result;	
		}
		public function getLastestSamsum()
		{
			$query = "SELECT * FROM tbl_sanpham where Mathuonghieu = '7' order by IdSanpham desc limit 1";
			$result = $this->db->select($query);
			return $result;	
		}
		public function get_compare($customer_id)
		{
			$query = "SELECT tbl_sosanh.*, tbl_sanpham.IdSanpham, tbl_sanpham.TenSanpham From tbl_sanpham INNER JOIN tbl_sosanh ON tbl_sanpham.IdSanpham = tbl_sosanh.IdSanpham where IdKhachhang = '$customer_id' order by id desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function get_wishlist($customer_id)
		{
			$query = "SELECT tbl_yeuthich.*,tbl_sanpham.IdSanpham, tbl_sanpham.TenSanpham From tbl_sanpham INNER JOIN tbl_yeuthich ON tbl_sanpham.IdSanpham = tbl_yeuthich.IdSanpham where IdKhachhang = '$customer_id' order by id desc";
			$result = $this->db->select($query);
			return $result;
		}
		public function insertCompare($productid, $customer_id)
		{
			$productid = mysqli_real_escape_string($this->db->link, $productid);
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			
			$check_compare = "SELECT * FROM tbl_sosanh WHERE IdSanpham = '$productid' AND IdKhachhang ='$customer_id'";
			$result_check_compare = $this->db->select($check_compare);

			if($result_check_compare){
				$msg = "<span class='error'>Sản phẩm đã được thêm vào so sánh</span>";
				return $msg;
			}else{

			$query = "SELECT * FROM tbl_sanpham WHERE IdSanpham = '$productid'";
			$result = $this->db->select($query)->fetch_assoc();

			$Gia = $result["Gia"];
			$image = $result["Hinhanh"];

			
			
			$query_insert = "INSERT INTO tbl_sosanh(IdSanpham,Gia,Hinhanh,IdKhachhang) VALUES('$productid','$Gia','$image','$customer_id')";
			$insert_compare = $this->db->insert($query_insert);

			if($insert_compare){
						$alert = "<span class='success'>Thêm sản phẩm vào so sánh thành công</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Thêm sản phẩm vào so sánh thất bại</span>";
						return $alert;
					}
			}

		}
		public function insertWishlist($productid, $customer_id)
		{
			$productid = mysqli_real_escape_string($this->db->link, $productid);
			$customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
			
			$check_wlist = "SELECT * FROM tbl_yeuthich WHERE IdSanpham = '$productid' AND IdKhachhang ='$customer_id'";
			$result_check_wlist = $this->db->select($check_wlist);

			if($result_check_wlist){
				$msg = "<span class='error'>Product Added to Wishlist</span>";
				return $msg;
			}else{

			$query = "SELECT * FROM tbl_sanpham WHERE IdSanpham = '$productid'";
			$result = $this->db->select($query)->fetch_assoc();
			

			$Gia = $result["Gia"];
			$image = $result["Hinhanh"];

			
			
			$query_insert = "INSERT INTO tbl_yeuthich(IdSanpham,Gia,Hinhanh,IdKhachhang) VALUES('$productid','$Gia','$image','$customer_id')";
			$insert_wlist = $this->db->insert($query_insert);

			if($insert_wlist){
						$alert = "<span class='success'>Thêm sản phẩm vào wishlist thành công</span>";
						return $alert;
					}else{
						$alert = "<span class='error'>Thêm sản phẩm vào wishlist thất bại</span>";
						return $alert;
					}
			}
		}
	}
 ?>