<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';  ?>
<?php include '../classes/cart.php';  ?>
<?php include '../classes/brand.php';  ?> 
<?php include '../classes/product.php';  ?>
<?php require_once '../helpers/format.php'; ?>
<?php 
	$pd = new product();
	$fm = new Format();
	if(!isset($_GET['productid']) || $_GET['productid'] == NULL){
        // echo "<script> window.location = 'catlist.php' </script>";
        
    }else {
        $id = $_GET['productid']; // Lấy catid trên host
        $delProduct = $pd -> del_product($id); // hàm check delete Name khi submit lên
    }
 ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Tất cả sản phẩm</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>ID</th>
					<th>Tên sản phẩm</th>
					<th>Mã sản phẩm</th>
					<th>Nhập hàng</th>
					<th>Số lượng nhập</th>
					<th>Đã bán</th>
					<th>Tồn</th>
					<th>Giá</th>
					<th>Hình ảnh</th>
					<th>Danh mục</th>
					<th>Thương hiệu</th>
					
					<th>Loại</th>
					<th>Xử lý</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				
				$pdlist = $pd->show_product();
				$i = 0;
				
				
					if($pdlist){
					
							while ($result = $pdlist->fetch_assoc()){
								$i++;
									
									
				 ?>
				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $result['TenSanpham'] ?></td>
					<td><?php echo $result['MaSanpham'] ?></td>
					<td><a href="productmorequantity.php?productid=<?php echo $result['IdSanpham'] ?>">Nhập hàng</a></td>
					<td>
						<?php echo $result['Soluong'] ?>

					</td>
					<td>
						<?php echo $result['Daban'] ?>

					</td>
					<td>
						<?php echo $result['Conlai'] ?>

					</td>
					<td><?php echo $result['Gia'] ?></td>
					<td><img src="uploads/<?php echo $result['Hinhanh'] ?>" width="80"></td>
					<td><?php echo $result['Tendanhmuc'] ?></td>
					<td><?php echo $result['Tenthuonghieu'] ?></td>
					
					<td><?php 
						if($result['Loai']==0){
							echo 'Nổi bật';
						}else{
							echo 'Không Nổi Bật';
						}

					?></td>
					
					<td><a href="productedit.php?IdSanpham=<?php echo $result['IdSanpham'] ?>">Edit</a> || <a href="?IdSanpham=<?php echo $result['IdSanpham'] ?>">Delete</a></td>
				</tr>
				<?php
							
						
					}
				}
				?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
