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
        <?php //print_r($userdata);
        $usertype = $this->user_model->getusertype($userdata->type);
        $uid = $userdata->id;
       $secure1 = rand(100,999).base64_encode($uid);
       ?>
        <div class="media-body">
          <h4 class="media-heading"><?php echo $userdata->username;?><a data-toggle="collapse" data-target="#loguserinfo" class="pull-right collapsed" aria-expanded="false"><i class="fa fa-angle-down"></i></a></h4>
          <?php
          if($usertype=='companyuser'){
			$customusertype = $this->user_model->getcusertype($userdata->customizedusertype);
			echo '<span>'.$customusertype.'</span>';
			}else{
				echo '<span>'.$usertype.'</span>';
			}
		?>
          
        </div>
      </div>
		<div class="leftpanel-userinfo collapse" id="loguserinfo" aria-expanded="false" style="height: 10px;">
        <ul class="list-group">
		<?php if($usertype=='superadmin'){?>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-lock"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/">Admin Area</a></span>
          </li>
          <?php }?>
          <?php if($usertype=='superadmin'){?>
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
          <?php }else if($usertype=='companyadmin'){?>
		   <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-pencil"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/useredit/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Edit Profile</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-user"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/changeavatar/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Avatar</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/changepass/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Password</a></span>
          </li>
          <?php }?>          
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
			<?php if($usertype=='superadmin'){?>
          <ul class="nav">
            <li><a href="<?php echo BASE_URL;?>admin/users/"><i class="fa fa-building" aria-hidden="true"></i> <span>Companies</span></a></li>
          </ul>
          <?php } else if($usertype=='companyadmin'){
			  $compid = $userdata->companyid;
			  $secure = rand(100,999).base64_encode($compid);
			  ?>
			  <ul class="nav">
				<li><a href="<?php echo BASE_URL;?>company/companyusers?id=<?php echo $secure;?>"><i class="fa fa-folder"></i> <span>Company</span></a></li>
			  </ul>
			  <ul class="nav">
				<li><a href="<?php echo BASE_URL;?>company/folders/"><i class="fa fa-folder"></i> <span>Folders</span></a></li>
			  </ul>
		   <?php }?>
		   <?php if($usertype=='companyuser'){?>
			   <ul class="nav">
				<li class="active"><a href="<?php echo BASE_URL;?>user/"><i class="fa fa-folder"></i> <span>Folders</span></a></li>
			  </ul>
			<?php }?>
        </div><!-- tab-pane -->
		
      </div>
	</div>
	<div id="right-col">
		<a id="mobilemenu" class="mobilemenu"><i class="fa fa-bars"></i></a>
		<div class="contentpanel">
			<div class="header">
				<div class="logohead">
					<img class="logo" src="<?php echo BASE_URL;?>images/logo_dark.png" alt="logo">
				</div>
				<div class="logout">
					<a href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out"></i>Logout</a>
				</div>
			</div><!--header-->
			
			<div class="row panel-quick-page">
          
            <?php if($usertype=='superadmin'){?>
            <div class="col-xs-3 col-sm-3 col-md-3 page-reports">
              <div class="panel">
                <div class="panel-heading">
                 <h4 class="panel-title" style="float: right;"><a href="<?php echo BASE_URL;?>admin/users/">Total Company..</a></h4>
               
                  <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 110px;">  <?php echo $totalcompany = $this->dashboard_model->sup_company();?></h4>
                </div>
                <div class="panel-body">
					<a href="<?php echo BASE_URL;?>admin/users/">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-building"></i></div>
                  </a>
                </div>
              </div>
            </div>
             <div class="col-xs-3 col-sm-3 col-md-3 page-user">
              <div class="panel" style="height: 106px;">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Users..</h4>
           
                <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 126px;margin-top: 2px;"> <?php echo $totaluser = $this->dashboard_model->sup_user();?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: 4px;margin-left: -5px;"><i class="fa fa-user" style="float: left;margin-top: -16px;"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 page-statistics">
              <div class="panel">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Folders..</h4>
                   <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 110px;"><?php echo $totalfolder = $this->dashboard_model->sup_folder();?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-folder fol"></i></div>
                </div>
              </div>
            </div>
             <div class="col-xs-3 col-sm-3 col-md-3 page-support">
              <div class="panel">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Files..</h4>
                   <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 110px;"><?php echo $totalfiles = $this->dashboard_model->sup_files();?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-file"></i></div>
                </div>
              </div>
            </div>
            </div>
            <?php }elseif($usertype=='companyadmin'){?>
				 <div class="col-xs-4 col-sm-4 col-md-4 page-user">
              <div class="panel" style="height: 106px;">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Users..</h4>
           
 <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 126px;margin-top: 15px;margin-right: -84px;"> <?php echo $comuser = $this->dashboard_model->com_user($companyid);?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: 4px;margin-left: -5px;"><i class="fa fa-user" style="float: left;margin-top: -16px;"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 page-statistics">
              <div class="panel">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Folders..</h4>
                   <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 126px;margin-top: 15px;margin-right: -84px;"><?php echo $comfolder = $this->dashboard_model->com_folder($companyid);?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-folder fol"></i></div>
                </div>
              </div>
            </div>
             <div class="col-xs-4 col-sm-4 col-md-4 page-support">
              <div class="panel">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Files..</h4>
                   <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 126px;margin-top: 15px;margin-right: -84px;"><?php echo $comfiles = $this->dashboard_model->com_files($companyid);?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-file"></i></div>
                </div>
              </div>
            </div>
            </div>
			<?php }else{ ?>
				
				 <div class="col-xs-3 col-sm-3 col-md-3 page-reports">
              <div class="panel">
                <div class="panel-heading">
                 <h4 class="panel-title" style="float: right;"><a href="<?php echo BASE_URL;?>admin/users/">Total Company Folders</a></h4>
               
                  <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 110px;">  <?php echo $usercomfolder = $this->dashboard_model->com_folder($companyid);?></h4>
                </div>
                <div class="panel-body">
					<a href="<?php echo BASE_URL;?>admin/users/">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-folder fol"></i></div>
                  </a>
                </div>
              </div>
            </div>
             <div class="col-xs-3 col-sm-3 col-md-3 page-user">
              <div class="panel" style="height: 106px;">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Company Files</h4>
           
                <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 126px;margin-top: 2px;"> <?php echo $usercomfiles = $this->dashboard_model->com_files($companyid);?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: 4px;margin-left: -5px;"><i class="fa fa-file" style="float: left;margin-top: -16px;"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 page-statistics">
              <div class="panel">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Folders..</h4>
                   <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 110px;"><?php echo $userfolder = $this->dashboard_model->user_folder($companyid,$userid);?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-folder fol"></i></div>
                </div>
              </div>
            </div>
             <div class="col-xs-3 col-sm-3 col-md-3 page-support">
              <div class="panel">
                <div class="panel-heading">
                <h4 class="panel-title" style="float: right;">Total Files..</h4>
                   <h4 class="panel-title" style="float: right;font-size: 50px;margin-left: 143px;"><?php echo $userfiles = $this->dashboard_model->user_files($companyid,$userid);?></h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon" style="margin-top: -15px;margin-left: -5px;"><i class="fa fa-file" style="float: left;margin-top: -12px;"></i></div>
                </div>
              </div>
            </div>
            </div>
				<?php }?>
            
          </div>
			
			
			
			<!--row panel-quick-page-->
			
		</div>
	</div>
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
	
});
</script>
