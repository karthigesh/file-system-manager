<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Change Password</h4>
	</div>
		<div class="panel-body">
	<form id="createcompanyform" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL;?>admin/passreset/">
	<div class="form-group">
		<input type="password" name="password" value="" required/>
	</div>
	<div class="form-group">
		<input type="hidden" name="userid" value="<?php echo $userid?>">
		<input class="btn btn-success" type="submit" name="company_submit" value="Change Password">
	</div>
	</form>
</div>
</div>
