 <div class="header_bottom">
		<div class="header_bottom_left">
			<div class="section group">
				<?php
				$getLastestDell = $product->getLastestDell();
				if($getLastestDell){
					while($resultdell = $getLastestDell->fetch_assoc()){
				 ?>
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="details.php?proid=<?php echo $resultdell['IdSanpham'] ?>"> <img src="admin/uploads/<?php echo $resultdell['Hinhanh'] ?>" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>YẾN ĐẢO THIÊN NHIÊN</h2>
						<p><?php echo $fm->textShorten($resultdell['TenSanpham'],35) ?></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $resultdell['IdSanpham'] ?>">Thêm vào giỏ</a></span></div>
				   </div>
			   </div>
			   <?php
				}}
			    ?>

			    <?php
				$getLastestSS = $product->getLastestSamsum();
				if($getLastestSS){
					while($resultss = $getLastestSS->fetch_assoc()){
				 ?>			
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						  <a href="details.php?proid=<?php echo $resultss['IdSanpham'] ?>"><img src="admin/uploads/<?php echo $resultss['Hinhanh'] ?>" alt="" /></a>
					</div>
					<div class="text list_2_of_1">
						  <h2>SANEST</h2>
						  <p><?php echo $fm->textShorten($resultss['TenSanpham'],35) ?></p>
						  <div class="button"><span><a href="details.php?proid=<?php echo $resultss['IdSanpham'] ?>">Thêm vào giỏ</a></span></div>
					</div>
				</div>
				<?php
				}}
			    ?>
			</div>
			<div class="section group">
				<?php
				$getLastestAP = $product->getLastestApple();
				if($getLastestAP){
					while($result_ap = $getLastestAP->fetch_assoc()){
				 ?>		
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="details.php?proid=<?php echo $result_ap['IdSanpham'] ?>"> <img src="admin/uploads/<?php echo $result_ap['Hinhanh'] ?>" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>SANNA</h2>
						<p><?php echo $fm->textShorten($result_ap['TenSanpham'],35) ?></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_ap['IdSanpham'] ?>">Thêm vào giỏ</a></span></div>
				   </div>
			   </div>
			   <?php
				}}
			    ?>

				<?php
				$getLastestHW = $product->getLastestHuawei();
				if($getLastestHW){
					while($result_hw = $getLastestHW->fetch_assoc()){
				 ?>		
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="details.php?proid=<?php echo $result_hw['IdSanpham'] ?>"> <img src="admin/uploads/<?php echo $result_hw['Hinhanh'] ?>" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>SANESTFOODS</h2>
						<p><?php echo $fm->textShorten($result_hw['TenSanpham'],35) ?></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_hw['IdSanpham'] ?>">Thêm vào giỏ</a></span></div>
				   </div>
			   </div>
			   <?php
				}}
			    ?>			
			</div>
		  <div class="clear"></div>
		</div>
			 <div class="header_bottom_right_images">
		   <!-- FlexSlider -->
             
			<section class="slider">
				  <div class="flexslider">
					<ul class="slides">
						<?php 
						$get_slider = $product->show_slider();
						if ($get_slider) {
							while ($result_slider = $get_slider->fetch_assoc()) {
								# code...
							
						 ?>
						<li><img src="admin/uploads/<?php echo $result_slider['AnhSlider'] ?>" alt=""/></li>
						<?php 
						}
						}
						 ?>
				    </ul>
				  </div>
	      </section>
<!-- FlexSlider -->
	    </div>
	  <div class="clear"></div>
  </div>