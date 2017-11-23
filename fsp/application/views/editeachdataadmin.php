<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Edit Company Dataadmin: <?php echo $userdetails->username;?></h4>
	</div>
	<?php //print_r($userdetails);?>
	<div class="panel-body">
	<form id="edituserform" method="POST" action="<?php echo BASE_URL;?>company/savedataadmin/">
	<div class="form-group">
		<input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $userdetails->username;?>" required>
	</div>
	<div class="form-group">
		<input type="text" name="fname" placeholder="First Name" class="form-control" value="<?php echo $userdetails->first_name;?>" required>
	</div>
	<div class="form-group">
		<input type="text" name="lname" placeholder="Last Name" class="form-control" value="<?php echo $userdetails->last_name;?>" required>
	</div>
	<div class="form-group">
		<input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo $userdetails->email;?>" required>
	</div>
	<div class="form-group">
		<input type="text" name="phone" placeholder="Phone" class="form-control" value="<?php echo $userdetails->phone;?>" required>
	</div>
	<div class="form-group">
		<input type="hidden" name="status" value="1">
		<input type="hidden" name="userid" value="<?php echo $userdetails->id;?>">
		<input type="hidden" name="url" value="<?php echo $editid;?>">
		<input class="btn btn-success" type="submit" name="user_submit" value="save data admin">
		
	</div>
	</form>
</div>
</div>
