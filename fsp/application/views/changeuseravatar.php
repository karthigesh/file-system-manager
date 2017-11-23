<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Change Avatar</h4>
	</div>
		<div class="panel-body">
	<form id="createcompanyform" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL;?>userfolder/avatarsave/">
	<div class="form-group">
		<input type="file" name="picture" accept="image/*" required>
	</div>
	<div class="form-group">
		<input class="btn btn-success" type="submit" name="company_submit" value="Change Avatar">
	</div>
	</form>
</div>
</div>
