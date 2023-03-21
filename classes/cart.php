<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/database.php');
	include_once ($filepath.'/../helpers/format.php');
?>


 
<?php 
	/**
	* 
	*/
	class cart
	{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function add_to_cart($id, $quantity)
		{
			$quantity = $this->fm->validation($quantity);
			$quantity = mysqli_real_escape_string($this->db->link, $quantity);
			$id = mysqli_real_escape_string($this->db->link, $id);
			$sId = session_id();

			$query = "SELECT * FROM tbl_sanpham WHERE IdSanpham = '$id' ";
			$result = $this->db->select($query)->fetch_assoc();

			$Gia = $result['Gia'];
			$Hinhanh = $result['Hinhanh'];
			if($result['Conlai']>$quantity){
			
				$query_insert = "INSERT INTO tbl_giohang(IdSanpham,Soluong,sId,Gia,Hinhanh) VALUES('$id','$quantity','$sId','$Gia','$Hinhanh' ) ";
				$insert_cart = $this->db->insert($query_insert);
				if($result){
					header('Location:cart.php');
				}else {
					header('Location:404.php');
				}
			}else{
				$msg = "<span class='erorr'> Số lượng ".$quantity." bạn đặt quá số lượng chúng tôi chỉ còn ".$result['Conlai']." cái</span> ";
				return $msg;
			}
			

		}
		public function get_product_cart()
		{
			$sId = session_id();
			$query = "SELECT tbl_giohang.*,tbl_sanpham.TenSanpham,tbl_sanpham.IdSanpham FROM tbl_sanpham
			INNER JOIN tbl_giohang ON tbl_sanpham.IdSanpham = tbl_giohang.IdSanpham  WHERE sId = '$sId' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function update_quantity_Cart($proId,$cartId, $quantity)
		{
			$quantity = mysqli_real_escape_string($this->db->link, $quantity);
			$cartId = mysqli_real_escape_string($this->db->link, $cartId);
			$proId = mysqli_real_escape_string($this->db->link, $proId);

			$query_product = "SELECT * FROM tbl_sanpham WHERE IdSanpham = '$proId' ";
			$result_product = $this->db->select($query_product)->fetch_assoc();
			if($quantity<$result_product['Conlai']){
				$query = "UPDATE tbl_giohang SET

				Soluong = '$quantity'

				WHERE IdGiohang = '$cartId'";

				$result = $this->db->update($query);
				if ($result) {
					header('Location:cart.php');
				}else {
					$msg = "<span class='erorr'> Product Quantity Update NOT Succesfully</span> ";
					return $msg;
				}
			}else{
				$msg = "<span class='erorr'> Số lượng ".$quantity." bạn đặt quá số lượng chúng tôi chỉ còn ".$result_product['Conlai']." cái</span> ";
				return $msg;
			}

		}
		public function del_product_cart($cartid){
			$cartid = mysqli_real_escape_string($this->db->link, $cartid);
			$query = "DELETE FROM tbl_giohang WHERE IdGiohang = '$cartid'";
			$result = $this->db->delete($query);
			if($result){
				header('Location:cart.php');
			}else{
				$msg = "<span class='error'>Sản phẩm đã được xóa</span>";
				return $msg;
			}
		}

		public function check_cart()
		{
			$sId = session_id();
			$query = "SELECT * FROM tbl_giohang WHERE sId = '$sId' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function check_order($customer_id)
		{
			$sId = session_id();
			$query = "SELECT * FROM tbl_muahang WHERE IdKhachhang = '$customer_id' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function del_all_data_cart()
		{
			$sId = session_id();
			$query = "DELETE FROM tbl_giohang WHERE sId = '$sId' ";
			$result = $this->db->select($query);
			return $result;
		}
		public function del_compare($customer_id){
			$sId = session_id();
			$result = $this->db->delete($query);
			return $result;
			$query = "DELETE FROM tbl_sosanh WHERE IdKhachhang = '$customer_id'";

		}
		public function insertOrder($customer_id)
		{
			$sId = session_id();
			$query = "SELECT * FROM tbl_giohang WHERE tbl_giohang.sId = '$sId'";
			$get_product = $this->db->select($query);
			if($get_product){
				while($result = $get_product->fetch_assoc()){
					$productid = $result['IdSanpham'];
					$quantity = $result['Soluong'];
					$price = $result['Gia'] * $quantity;
					$image = $result['Hinhanh'];
					$customer_id = $customer_id;
					$query_order = "INSERT INTO tbl_muahang(IdSanpham,Soluong,Gia,Hinhanh,IdKhachhang) VALUES('$productid','$quantity','$price','$image','$customer_id')";
					$insert_order = $this->db->insert($query_order);
				}
			}
		}
		public function getAmountPrice($customer_id)
		{
			$query = "SELECT Gia FROM tbl_muahang WHERE IdKhachhang = '$customer_id' ";
			$get_price = $this->db->select($query);
			return $get_price;
		}
		public function get_cart_ordered($customer_id)
		{
			$query = "SELECT tbl_muahang.*, tbl_sanpham.IdSanpham, tbl_sanpham.TenSanpham FROM tbl_sanpham
			INNER JOIN tbl_muahang ON tbl_sanpham.IdSanpham = tbl_muahang.IdSanpham  WHERE IdKhachhang = '$customer_id' ";
			$get_cart_ordered = $this->db->select($query);
			return $get_cart_ordered;
		}
		public function get_inbox_cart()
		{
			$query = "SELECT tbl_muahang.*, tbl_sanpham.IdSanpham, tbl_sanpham.TenSanpham

			 FROM tbl_sanpham INNER JOIN tbl_muahang ON tbl_sanpham.IdSanpham = tbl_muahang.IdSanpham ";
			$get_inbox_cart = $this->db->select($query);
			return $get_inbox_cart;
		}
		
		public function shifted($id,$proid,$qty,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$proid = mysqli_real_escape_string($this->db->link, $proid);
			$qty = mysqli_real_escape_string($this->db->link, $qty);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);

			$query_select = "SELECT * FROM tbl_sanpham WHERE IdSanpham ='$proid'";
			$get_select = $this->db->select($query_select);

			if($get_select){
				while($result = $get_select->fetch_assoc()){
					$soluong_new = $result['Conlai'] - $qty;
					$qty_soldout = $result['Daban'] + $qty;

					$query_soluong = "UPDATE tbl_sanpham SET

					Conlai += '$soluong_new', Daban += '$qty_soldout' WHERE IdSanpham = '$proid'";
					$result = $this->db->update($query_soluong);
				}
			}

			$query = "UPDATE tbl_muahang SET

			Tinhtrang = '1'

			WHERE IdDonhang = '$id' AND NgayDat = '$time' AND Gia = '$price' ";


			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Update Order Succesfully</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> Update Order NOT Succesfully</span> ";
				return $msg;
			}
		}
			public function shifted1($id,$proid,$qty,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$proid = mysqli_real_escape_string($this->db->link, $proid);
			$qty = mysqli_real_escape_string($this->db->link, $qty);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);

			$query_select = "SELECT * FROM tbl_sanpham WHERE IdSanpham ='$proid'";
			$get_select = $this->db->select($query_select);

			if($get_select){
				while($result = $get_select->fetch_assoc()){
					$soluong_new = $result['Conlai'] - $qty;
					$qty_soldout = $result['Daban'] + $qty;

					$query_soluong = "UPDATE tbl_sanpham SET

					Conlai += '$soluong_new', Daban += '$qty_soldout' WHERE IdSanpham = '$proid'";
					$result = $this->db->update($query_soluong);
				}
			}

			$query = "UPDATE tbl_muahang SET

			Tinhtrang = '2'

			WHERE IdDonhang = '$id' AND NgayDat = '$time' AND Gia = '$price' ";


			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Update Order Succesfully</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> Update Order NOT Succesfully</span> ";
				return $msg;
			}
		}
		public function shifted2($id,$proid,$qty,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$proid = mysqli_real_escape_string($this->db->link, $proid);
			$qty = mysqli_real_escape_string($this->db->link, $qty);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);

			$query_select = "SELECT * FROM tbl_sanpham WHERE IdSanpham ='$proid'";
			$get_select = $this->db->select($query_select);

			if($get_select){
				while($result = $get_select->fetch_assoc()){
					$soluong_new = $result['Conlai'] - $qty;
					$qty_soldout = $result['Daban'] + $qty;

					$query_soluong = "UPDATE tbl_sanpham SET

					Conlai += '$soluong_new', Daban += '$qty_soldout' WHERE IdSanpham = '$proid'";
					$result = $this->db->update($query_soluong);
				}
			}

			$query = "UPDATE tbl_muahang SET

			Tinhtrang = '3'

			WHERE IdDonhang = '$id' AND NgayDat = '$time' AND Gia = '$price' ";


			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> Update Order Succesfully</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> Update Order NOT Succesfully</span> ";
				return $msg;
			}
		}
		public function del_shifted($id,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$query = "DELETE FROM tbl_muahang 
					  WHERE IdDonhang = '$id' AND NgayDat = '$time' AND Gia = '$price' ";

			$result = $this->db->update($query);
			if ($result) {
				$msg = "<span class='success'> DELETE Order Succesfully</span> ";
				return $msg;
			}else {
				$msg = "<span class='erorr'> DELETE Order NOT Succesfully</span> ";
				return $msg;
			}
		}
		public function shifted_confirm($id,$time,$price)
		{
			$id = mysqli_real_escape_string($this->db->link, $id);
			$time = mysqli_real_escape_string($this->db->link, $time);
			$price = mysqli_real_escape_string($this->db->link, $price);
			$query = "UPDATE tbl_muahang SET

			Tinhtrang = '4'

			WHERE IdKhachhang = '$id' AND NgayDat = '$time' AND Gia = '$price' ";

			$result = $this->db->update($query);
			return $result;
		}
	}
 ?>