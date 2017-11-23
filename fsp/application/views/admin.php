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
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right">Account Settings</span>
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
            <li><a href="<?php echo BASE_URL;?>admin/users/"><i class="fa fa-users"></i> <span>Users</span></a></li>
          </ul>
          <ul class="nav">
            <li><a href="<?php echo BASE_URL;?>dashboard/"><i class="fa fa-home"></i> <span>Recent</span></a></li>
          </ul>
          <ul class="nav">
            <li><a href="<?php echo BASE_URL;?>dashboard/"><i class="fa fa-home"></i> <span>Favourites</span></a></li>
          </ul>
          <ul class="nav">
            <li><a href="<?php echo BASE_URL;?>dashboard/"><i class="fa fa-home"></i> <span>Trash</span></a></li>
          </ul>
        </div><!-- tab-pane -->
		
      </div>
	</div>
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
			<div class="row panel-quick-page">
            <div class="col-xs-4 col-sm-4 col-md-4 page-user">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title"><a href="<?php echo BASE_URL;?>admin/users/">Manage Users</a></h4>
                </div>
                <div class="panel-body">
					<a href="<?php echo BASE_URL;?>admin/users/">
                  <div class="page-icon"><i class="fa fa-users"></i></div>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Reports</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-statistics">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Statistics</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-ios-pulse-strong"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 page-support">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Support</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-help-buoy"></i></div>
                </div>
              </div>
            </div>
          </div><!--row panel-quick-page-->
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
