<?php //print_r($inivalue);?>
<header>
	<div class="row">
		<?php if($inivalue){?>
		<div class="col-md-4">
			<?php if(($inivalue['login_placement'] =='topleft')){?>
			<div class="signup_button"> <a href="<?php echo BASE_URL.'companyview/'.$title.'/login/'?>"><i class="fa fa-sign-in"></i> Sign In</a></div><br>
			<?php }?>
			<div class="logo">
				<a href="<?php echo BASE_URL.'companyview/'.$title;?>"><img 
				src="<?php echo BASE_URL.'images/'.$company->picture;?>" alt="<?php 
				echo $company->name;?>" style="width: 100px;"/></a>
			</div>
			
		</div>
		<div class="col-md-4">
			<?php if($inivalue['login_placement'] =='center'){?>
				<div class="login"><a href=""><i class="fa fa-sign-in"></i> Sign In</a></div>
			<?php }?>
			<div class="menu">
				<ul style="margin-right: 100px;">
					<li><a href="<?php echo BASE_URL.'companyview/'.$title;?>">Home</a></li>
					<li class="last"><a href="<?php echo BASE_URL.'companyview/'.$title.'/about/'?>">About us</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-4">
			<?php if($inivalue['login_placement'] =='topright'):?>
				<div class="login"><a href=""><i class="fa fa-sign-in"></i> Sign In</a></div>
			<?php endif;?>
			<div class="social">
				<?php $social = unserialize(base64_decode($company->links));
				//print_r($social);?>
				<ul>
					<?php 
					if($social['facebook']!=""){
						echo '<li><a href="'.$social['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
					}
					if($social['facebook']!=""){
						echo '<li><a href="'.$social['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
					}
					if($social['googleplus']!=""){
						echo '<li><a href="'.$social['googleplus'].'"><i class="fa fa-google-plus"></i></a></li>';
					}
					if($social['linkedin']!=""){
						echo '<li><a href="'.$social['linkedin'].'"><i class="fa fa-linkedin"></i></a></li>';
					}
					if($social['instagram']!=""){
						echo '<li><a href="'.$social['instagram'].'"><i class="fa fa-instagram"></i></a></li>';
					}
					if($social['pinterest']!=""){
						echo '<li><a href="'.$social['pinterest'].'"><i class="fa fa-pinterest"></i></a></li>';
					}
					?>
				</ul>
			</div>
		</div>
		<?php }else{?>
			<div class="col-md-4">
			<div class="logo">
				<a href="<?php echo BASE_URL.'companyview/'.$title;?>"><img src="<?php echo BASE_URL.'images/'.$company->picture;?>" alt="<?php echo $company->name;?>" style="width: 150px;"/></a>
			</div>
		</div>
		<div class="col-md-4">
			<div class="menu">
				<ul>
					<li><a href="<?php echo BASE_URL.'companyview/'.$title;?>">Home</a></li>
					<li class="last"><a href="<?php echo BASE_URL.'companyview/'.$title.'/about/'?>">About us</a></li>
				</ul>
			</div>
		</div>
		<div class="col-md-4">
			<div class="social">
				<ul>
					<li><a href=""><i class="fa fa-sign-in"></i> Sign In</a></li>
				</ul>
				<?php $social = unserialize(base64_decode($company->links));
				//print_r($social);?>
				<ul>
					<?php 
					if($social['facebook']!=""){
						echo '<li><a href="'.$social['facebook'].'"><i class="fa fa-facebook"></i></a></li>';
					}
					if($social['facebook']!=""){
						echo '<li><a href="'.$social['twitter'].'"><i class="fa fa-twitter"></i></a></li>';
					}
					if($social['googleplus']!=""){
						echo '<li><a href="'.$social['googleplus'].'"><i class="fa fa-google-plus"></i></a></li>';
					}
					if($social['linkedin']!=""){
						echo '<li><a href="'.$social['linkedin'].'"><i class="fa fa-linkedin"></i></a></li>';
					}
					if($social['instagram']!=""){
						echo '<li><a href="'.$social['instagram'].'"><i class="fa fa-instagram"></i></a></li>';
					}
					if($social['pinterest']!=""){
						echo '<li><a href="'.$social['pinterest'].'"><i class="fa fa-pinterest"></i></a></li>';
					}
					?>
				</ul>
			</div>
		</div>
		<?php }?>
	</div>
</header>
