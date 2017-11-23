<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title"><?php echo $title;?></h4>
	</div>
		<div class="panel-body">
	<form id="createcompanyform" method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL;?>company/inisave/">
	<div class="form-group">
		<input type="file" name="inifile" accept=".ini">
		<div>Accepts only ini file</div>
	</div>
	<div class="form-group">
		<input type="hidden" name="companyid" value="<?php echo $companyid;?>"/>
		<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
		<input class="btn btn-success" type="submit" name="company_submit" value="Customize Company">
	</div>
	</form>
</div>
</div>
