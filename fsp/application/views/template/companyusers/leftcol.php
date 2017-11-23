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
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-lock"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>dashboard/">Dashboard</a></span>
          </li>
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
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/profileedit/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Edit Profile</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-user"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/changeavatar/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Avatar</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/changepass/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Password</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/userini/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Ini Settings</a></span>
          </li>
          <?php }else if($usertype=='companyuser'){?>        
		  <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-pencil"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>userfolder/profileedit/" data-target="#userajax" data-toggle="modal">Edit Profile</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-user"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>userfolder/changeavatar/" data-target="#userajax" data-toggle="modal">Change Avatar</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>userfolder/changepass/" data-target="#userajax" data-toggle="modal">Change Password</a></span>
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
            <li class="active"><a href="<?php echo BASE_URL;?>admin/users/"><i class="fa fa-users"></i> <span>Users</span></a></li>
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
          <?php } else if($usertype=='companyadmin'){
			  $compid = $userdata->companyid;
			  $secure = rand(100,999).base64_encode($compid);
			  //echo $current_menu;
			  ?>
			  <ul class="nav">
				<li <?php if($current_menu == 'companyusers'){echo 'class="active"';}?>><a href="<?php echo BASE_URL;?>company/companyusers?id=<?php echo $secure;?>"><i class="fa fa-folder"></i> <span>Company</span></a></li>
			  </ul>
			  <ul class="nav">
				<li <?php if($current_menu == 'folders'){echo 'class="active"';}?>><a href="<?php echo BASE_URL;?>company/folders"><i class="fa fa-folder"></i> <span>Folders</span></a></li>
			  </ul>
		   <?php }elseif($usertype=='companyuser'){?>
			   <ul class="nav">
				<li class="active"><a href="<?php echo BASE_URL;?>user/"><i class="fa fa-folder"></i> <span>Folders</span></a></li>
			  </ul>
			<?php }?>
        </div><!-- tab-pane -->
		
      </div>
	</div><!-- left col-->
<script>
$(document).ready(function() {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
