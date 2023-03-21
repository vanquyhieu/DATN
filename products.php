<?php 
	include 'inc/header.php';
	include 'inc/slider.php';
 ?>

<div class="content_bottom">
    		<div class="heading">
    		<h3>Sản phẩm</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
    	<div class="section group">
			<?php 
	      	$product_new = $product->getproduct_all();
	      	if($product_new){
	      		while ($result_new = $product_new->fetch_assoc()) {
	      			      	
	      	 ?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="details.php?proid=<?php echo $result_new['IdSanpham'] ?>"><img src="admin/uploads/<?php echo $result_new['Hinhanh'] ?>" alt="" /></a>
					 <h2><?php echo $result_new['TenSanpham'] ?></h2>
					 <p><?php echo $fm->textShorten($result_new['Mota'], 50) ?></p>
					 <p><span class="price"><?php echo $fm->format_currency($result_new['Gia'])." VND" ?></span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result_new['IdSanpham'] ?>" class="details">Chi tiết</a></span></div>
				</div>
			<?php 
				}
				}
			?>
			</div>
<?php 
	include 'inc/footer.php';
 ?>

