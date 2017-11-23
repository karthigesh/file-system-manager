<div id="index_content">
	<div id="left-col">
		<div class="media leftpanel-profile">
        <div class="media-left">
            <?php if(isset($picture)&&($picture!="")){?>
				<img src="<?php echo BASE_URL;?>images/<?php echo $picture;?>" alt="" class="media-object img-circle">
			<?php }else{?>
				<img src="<?php echo BASE_URL;?>images/avatars/male.png" alt="" class="media-object img-circle">
			<?php }?>
        </div>
       <?php //print_r($userdata);?>
       <?php $uid = $userdata->id;
       $secure1 = rand(100,999).base64_encode($uid);
       ?>
        <div class="media-body">
          <h4 class="media-heading"><?php echo $userdata->username;?> <a data-toggle="collapse" data-target="#loguserinfo" class="pull-right collapsed" aria-expanded="false"><i class="fa fa-angle-down"></i></a></h4>
          <span><?php echo $usertype;?></span>
        </div>
      </div>
		<div class="leftpanel-userinfo collapse" id="loguserinfo" aria-expanded="false" style="height: 10px;">
        <ul class="list-group">
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-lock"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>dashboard/">Dashboard</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-pencil"></i></label>
            
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/useredit/?id=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Edit Profile</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-user"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/changeavatar/?id=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Avatar</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/changepass/?id=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Password</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-sign-out"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>logout">Logout</a></span>
          </li>
        </ul>
      </div>
	<ul class="nav nav-tabs nav-justified nav-sidebar">
		<li class="tooltips active" data-toggle="tooltip" title="" data-original-title="Main Menu"><a data-toggle="tab" data-target="#mainmenu"><i class="tooltips fa fa-ellipsis-h" data-original-title="" title=""></i></a></li>
		<li class="tooltips" data-toggle="tooltip" title="" data-original-title="Log Out" aria-describedby="tooltip79033"><a href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out"></i></a></li>
	</ul>
	<div class="tab-content">

        <!-- ################# MAIN MENU ################### -->

        <div class="tab-pane active" id="mainmenu">
          <ul class="nav">
            <li class="active"><a href="<?php echo BASE_URL;?>admin/users/"><i class="fa fa-users"></i> <span>Users</span></a></li>
          </ul>
        </div><!-- tab-pane -->
		
      </div>
	</div><!-- left col-->
	<div id="right-col">
		<div class="contentpanel">
			<div class="header">
				<div class="logohead">
					<img class="logo" src="<?php echo BASE_URL;?>images/logo_dark.png" alt="logo">
				</div>
				<div class="logout">
					<a href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out"></i>Logout</a>
				</div>
			</div><!--header-->
			<div class="panel">
				<div class="row panel-heading">
					<div class="col-sm-6">
						<?php echo $this->session->flashdata('companyupdation'); ?> 
						<h4 class="panel-title">Manage Company</h4>
					</div>
					<div class="col-sm-6">
					</div>          
				</div>
				<div class="panel-body">
					<div class="row tab-side-wrapper">
						<div class="col-xs-4 col-sm-3 tab-left">
						<!-- Nav tabs -->
							<ul class="nav nav-pills nav-stacked">
								<li class="active"><a href="#account" data-toggle="tab" aria-expanded="false"><strong>Company Settings</strong></a></li>
								<li class=""><a href="#about" data-toggle="tab" aria-expanded="false"><strong>About Us</strong></a></li>
								<li class=""><a href="#usefullinks" data-toggle="tab" aria-expanded="false"><strong>Useful links</strong></a></li>
							</ul>
						</div>
						<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3 tab-main">
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active" id="account">
									<?php //print_r($company);?>
									<?php if($company!=""){?>
									<form name="accountform" action="<?php echo BASE_URL;?>admin/caccountsave/" id="accountform" method="POST" enctype="multipart/form-data" aria-required="true">
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'	=>'cname',
											'name'       => 'cname',
											'placeholder'	=> 'Company Name',
											'value'		=>$company->name,
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<label><strong>Choose Your Company Picture :</strong></label>
											<input type="hidden" name="picture" value="<?php echo $company->picture;?>">
											<div class="cpicture"><img src="<?php echo IMG_PATH.$company->picture;?>"/></div>
											<input type="file" name="picture" accept="image/*" >
										</div>
										<div class="form-group">
											<label><strong>Set your Splash Screen</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'summernote',
											'name'       => 'splashscreen',
											'placeholder'	=> 'Enter Some Details',
											'value'		=> $company->splashscreen,
											'rows'=>'20',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											?>  
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $_GET['id'];?>">
											<input class="btn btn-success" type="submit" name="account_submit" value="Submit">
										</div>
									</form>
									<?php }else{?>
									<form name="accountform" action="<?php echo BASE_URL;?>admin/caccountsave/" id="accountform" method="POST" enctype="multipart/form-data" aria-required="true">
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'	=>'cname',
											'name'       => 'cname',
											'placeholder'	=> 'Company Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<label><strong>Choose Your Company Picture :</strong></label>
											<input type="file" name="picture" required accept="image/*" >
										</div>
										<div class="form-group">
											<label><strong>Set your Splash Screen</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'summernote',
											'name'       => 'splashscreen',
											'placeholder'	=> 'Enter Some Details',
											'rows'=>'20',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											?>  
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $_GET['id'];?>">
											<input class="btn btn-success" type="submit" name="account_submit" value="Submit">
										</div>
									</form>
									<?php }?>
								</div>
								<div class="tab-pane" id="about">
									<form name="aboutcontent" id="aboutcontent" action="<?php echo BASE_URL;?>admin/aboutsave/" method="POST" enctype="multipart/form-data" aria-required="true">
										<div class="form-group">
											<?php
											if($company !=""){
											if($company->about !=""){
											$aboutdata = unserialize(base64_decode($company->about));?>
											<label><strong>About us page content</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'aboutus',
											'name'       => 'aboutus',
											'placeholder'	=> 'Enter Some Details',
											'value'		=> $aboutdata,
											'rows'=>'20',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											}else{
											?>
											<label><strong>About us page content</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'aboutus',
											'name'       => 'aboutus',
											'placeholder'	=> 'Enter Some Details',
											'rows'=>'50',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											}
											}else{
											?>
											<label><strong>About us page content</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'aboutus',
											'name'       => 'aboutus',
											'placeholder'	=> 'Enter Some Details',
											'rows'=>'50',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											}
											?>  
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $_GET['id'];?>">
											<input class="btn btn-success" type="submit" name="about_submit" value="Submit">
										</div>
									</form>
								</div>
								<div class="tab-pane" id="usefullinks">
									<form name="usefullinks" id="usefullinks" action="<?php echo BASE_URL;?>admin/socialsave/" method="POST" enctype="multipart/form-data" aria-required="true">
										<h2 class="text-primary"><strong><?php echo 'Social Links';?></strong></h2>
										<p><?php echo '<strong>Hint:</strong> Enter the full link including the http://';?></p>
										<?php 
										if(($company!="")&&($company->links !="")){
											$sociallinks = unserialize(base64_decode($company->links));
										?>
										<div class="row">
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Facebook';?></strong></label>
											<input type="text" class="form-control bottom-border" name="fb" id="fb" value="<?php echo $sociallinks['facebook'];?>"/>
										</div>
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Twitter';?></strong></label>
											<input type="text" class="form-control bottom-border" name="tw" id="tw" value="<?php echo $sociallinks['twitter'];?>"/>
										</div>
										</div>
										<div class="row">
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Linkedin';?></strong></label>
											<input type="text" class="form-control bottom-border" name="ln" id="ln" value="<?php echo $sociallinks['linkedin'];?>"/>
										</div>
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Instagram';?></strong></label>
											<input type="text" class="form-control bottom-border" name="in" id="in" value="<?php echo $sociallinks['instagram'];?>"/>
										</div>
										</div>
										<div class="row">
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Google Plus';?></strong></label>
											<input type="text" class="form-control bottom-border" name="gp" id="gp" value="<?php echo $sociallinks['googleplus'];?>"/>
										</div>
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Pinterest';?></strong></label>
											<input type="text" class="form-control bottom-border" name="pt" id="pt" value="<?php echo $sociallinks['pinterest'];?>"/>
										</div>
										</div>
										<?php }else{?>
										<div class="row">
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Facebook';?></strong></label>
											<input type="text" class="form-control bottom-border" name="fb" id="fb" value=""/>
										</div>
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Twitter';?></strong></label>
											<input type="text" class="form-control bottom-border" name="tw" id="tw" value=""/>
										</div>
										</div>
										<div class="row">
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Linkedin';?></strong></label>
											<input type="text" class="form-control bottom-border" name="ln" id="ln" value=""/>
										</div>
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Instagram';?></strong></label>
											<input type="text" class="form-control bottom-border" name="in" id="in" value=""/>
										</div>
										</div>
										<div class="row">
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Google Plus';?></strong></label>
											<input type="text" class="form-control bottom-border" name="gp" id="gp" value=""/>
										</div>
										<div class="form-group col-sm-6">
											<label class="text-primary"><strong><?php echo 'Pinterest';?></strong></label>
											<input type="text" class="form-control bottom-border" name="pt" id="pt" value=""/>
										</div>
										</div>
										<?php }?>
										<div class="row">
										<div class="form-group col-sm-7 col-sm-offset-5">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $_GET['id'];?>">
											<input type="submit" class="btn btn-success btn-quirk btn-wide mr5" name="socialsubmit" value="Submit"/>
										</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div><!--tab-side-wrapper-->
				</div><!--panel-body-->
			</div><!-- panel -->
		</div><!--contentpanel-->
	</div><!-- right-col-->
</div>
<div class="modal fade" id="userajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
	
	$('#select1, #select2, #select3').select2();
});
</script>
