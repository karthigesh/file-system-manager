<div class="header">
				<div class="logohead">
					<img class="logo" src="<?php echo BASE_URL;?>images/logo_dark.png" alt="logo">
				</div>
				<div class="logosearch">
				<form name="search" id="search"	method="POST" action="<?php echo BASE_URL;?>search/user_search">	
				<div class="input-group searches">
					<?php if(isset($_POST['keyword'])){ ?>
					<input type="text" name="keyword" id="searchtext" class="form-control" value="<?php echo $_POST['keyword'];?>" placeholder="Search for Files and Folders">
					<?php } else { ?>
						<input type="text" name="keyword" id="searchtext" class="form-control" placeholder="Search for Files and Folders">
					<?php } ?>
					<span class="input-group-btn">
						<button type="submit" name="submit" class="btn btn-default">Go!</button>
					</span>
				</div>
				
</form>
				</div>
				<div class="logout">
					<a href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out"></i>Logout</a>
				</div>
			</div><!--header-->
