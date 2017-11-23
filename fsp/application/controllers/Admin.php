<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->library('upload');
		$this->load->helper(array('form', 'url'));
		$userdata= $this->session->userinfo;
		if(!$userdata){
			redirect('login');
		}
	}
	
	public function index(){
	$userdata= $this->session->userinfo;
	$picture= $this->session->picture;
	if($userdata){
	$data = array(
		'view_file'     =>'admin',
		'current_menu'  =>'admin',
		'site_title'    =>'File System Portal',
		'title'         =>'Admin',
		'content_title' =>'Admin',
		'userdata'		=> $userdata,
		'picture'		=>$picture,
		'files'         => array(
							"js" => array(
								"lib/jquery-toggles/toggles.js",
								"js/quirk.js"
								)
		)
	);
		$this->template->load_admin_template($data);
	}else{
		redirect('login');
	}
	}
	public function users(){
		$userdata= $this->session->userinfo;
		$picture= $this->session->picture;
		$userinfo = $this->user_model->getUser(array("type" => '2'));
		$userdetails = ($userinfo->num_rows() > 0) ? $userinfo->result() : FALSE;
		if($userdata){
		$data = array(
			'view_file'     =>'users',
			'current_menu'  =>'users',
			'site_title'    =>'File System Portal',
			'title'         =>'Admin Users',
			'content_title' =>'Users',
			'userdetails' => $userdetails,
			'userdata'		=> $userdata,
			'picture'		=>$picture,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
			$this->template->load_adminuser_template($data);
		}else{
			redirect('login');
		}
	}
	function astatuschange(){
		  $adminid = $this->input->post('adminid');
		  $status = $this->input->post('adminstatus');
		  if($status == 'ON'){
			  $newstatus = 1;
		  }else if($status == 'OFF'){
			  $newstatus = 0;
		  }
		  $data = array(
				'status' => $newstatus
			);
		  $statuschange = $this->user_model->update_user_status($adminid , $data);
		  //print_r($statuschange);exit;
		  if($statuschange){
			  if($statuschange->status == 1){
				  $this->session->set_flashdata('adminupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$statuschange->username.' has been activated successfully </span></div>');
			  }else if($statuschange->status == 0){
				  $this->session->set_flashdata('adminupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$statuschange->username.' has been deactivated successfully </span></div>');
			  }
			  redirect('admin/users');
		  }
	  }
	  public function useredit(){
		  $getid = $_GET['id'];
		  $unsecure = substr($getid,3);
		  $userid = base64_decode($unsecure);
		  $userinfo = $this->user_model->getUser(array("id" => $userid));
		  $userdetails = ($userinfo->num_rows() > 0) ? $userinfo->row() : FALSE;
		  $data = array(
			'view_file'     =>'editeachcompany',
			'userdetails' => $userdetails,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
			$this->template->load_edituser_template($data);
	  }
	  public function editsave(){
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'gender'=>$this->input->post('gender'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'status'=>$this->input->post('status'),
			'modified'=>date('Y-m-d H:i:s')
		 );
		 $userid = $this->input->post('userid');
		 $username = $this->input->post('name');
		 $userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		 if($userupdated==1){
			  $this->session->set_flashdata('adminupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$username.' has been saved successfully </span></div>');
		 }else{
			 $this->session->set_flashdata('adminupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$username.' has not been saved.Please try again </span></div>');
		 }
		 redirect('admin/users');
	  }
	  public function userdelete(){
		  $getid = $_GET['id'];
		  $unsecure = substr($getid,3);
		  $userid = base64_decode($unsecure);
		  $deleteadmin = $this->user_model->delete_user($userid);
		  $userinfo = $this->user_model->getUser(array("id" => $userid));
		  $userdetails = ($userinfo->num_rows() > 0) ? $userinfo->row() : FALSE;
		  if($deleteadmin==1){
			  $this->session->set_flashdata('adminupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$userdetails->username.' has been deleted successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('adminupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$username.' has not been saved.Please try again </span></div>');
		  }
		  redirect('admin/users');		  
	  }
	  public function changeavatar(){
		 $getid = $_GET['id'];
		 $data = array(
			'view_file'     =>'changeavatar',
			'current_menu'  =>'changeavatar',
			'site_title'    =>'File System Portal',
			'title'         =>'changeavatar',
			'content_title' =>'changeavatar',
			'userid'		=> $getid,
			);
			$this->template->load_adminuser_template($data);
	  }
	  public function avatarsave(){
		  $config['upload_path'] = FCPATH.'images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
			}
			 if($_FILES['picture']['name']!= '')
			{
				$picture=$_FILES['picture']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];   

			}
			$data=array(
					'picture'=>	$picturename,
					);
			$getid = $this->input->post('userid');
			$unsecure = substr($getid,3);
			$userid = base64_decode($unsecure);
			$userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
			$this->session->set_userdata('picture', $picturename);
			if($userupdated==1){
			  $this->session->set_flashdata('adminupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Avatar has been updated successfully </span></div>');
			}
			redirect('admin/users');
	  }
	  public function changepass(){
		 $getid = $_GET['id'];
		 $data = array(
			'view_file'     =>'changepass',
			'current_menu'  =>'changepass',
			'site_title'    =>'File System Portal',
			'title'         =>'changepass',
			'content_title' =>'changepass',
			'userid'		=> $getid,
			);
			$this->template->load_adminuser_template($data);
	  }
	  public function passreset(){
		$getid = $this->input->post('userid');
		$unsecure = substr($getid,3);
		$userid = base64_decode($unsecure);
		$password = $this->input->post('password');
		$data=array(
					'password'=>MD5($password),
					);
		$userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		if($userupdated==1){
			  $this->session->set_flashdata('adminupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Password has been updated successfully </span></div>');
			}
		redirect('admin/users');
	  }
	  public function createcompany(){
		  $data = array(
			'view_file'     =>'createcompany',
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
		$this->template->load_createuser_template($data);
	  }
	  public function newcompany(){
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'password'=>MD5($this->input->post('password')),
			'status'=>1,
			'type'=>2,
			'created'=>date('Y-m-d H:i:s')
		 );
		 $companyid = $this->user_model->insert_user($data);		 
		 $data=array('companyid'=>$companyid);
		 $updatecomp= $this->user_model->updateUser($data, array('id'=>$companyid));
		 if($updatecomp){
			  $this->session->set_flashdata('adminupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company has been created successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('adminupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company has not been saved.Please try again </span></div>');
		  }
		  redirect('admin/users');
	  }
	  public function manage_company(){
		  $this->load->library('form_validation');
		  $userdata= $this->session->userinfo;
		  $picture= $this->session->picture;
		  $usertype  = $this->user_model->getusertype($userdata->type);
		  $getid = $_GET['id'];
		  $unsecure = substr($getid,3);
		  $companyid = base64_decode($unsecure);
		  $companynamedetails = $this->company_model->getCompanydetails($companyid);
		  if($companynamedetails != false){
			 $companynamedetails =$companynamedetails;
		  }else{
			$companynamedetails = "";
		  }
		  $data = array(
			'view_file'     =>'editcompany',
			'current_menu'  =>'Edit Company',
			'site_title'    =>'File System Portal',
			'title'         =>'Edit Company',
			'content_title' =>'Edit Company',
			'secureid'		=>$getid,
			'userdata'		=>$userdata,
			'usertype'		=>$usertype,
			'companyid'		=> $companyid,
			'company'		=> $companynamedetails,
			'picture'		=> $picture,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css",
									"lib/summernote/summernote.css",
									"lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.css",
								),
								"js" => array(
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"lib/wysihtml5x/wysihtml5x.js",
									"lib/wysihtml5x/wysihtml5x-toolbar.js",
									"lib/summernote/summernote.js",
									"lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.all.js",
									"js/quirk.js",
									"js/jquery.validate.min.js"
									)
								)
			);
			$this->template->load_admincomcreate_template($data);

	  }
	  public function caccountsave(){
		  $config['upload_path'] = FCPATH.'images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());

				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				
			}
			 if($_FILES['picture']['name']!= '')
			{
				$picture=$_FILES['picture']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];   

			}   
			else
			{
				$picturename = $this->input->post('picture'); 
			}
			$url = $this->input->post('url');
			$parentid = $this->input->post('parentid');
			$cname = $this->input->post('cname');
			$data=array(
					'company_id'	=>	$this->input->post('parentid'),
					'name'			=>	str_replace(' ', '-', strtolower($cname)),
					'picture'		=>	$picturename,
					'splashscreen'	=>	$this->input->post('splashscreen'),
					//'links'=>$this->input->post('password'),
					);
			$companyget = $this->company_model->getCompanydetails($parentid);
			if($companyget=='-1'){
				$companyinsert = $this->company_model->insertCompanydetails($data);
				$this->session->set_flashdata('companyupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Account details has been created successfully </span></div>');
			}else{
			$companyupdated = $this->company_model->updateCompanydetails($data,array('company_id'=>$parentid));
				$this->session->set_flashdata('companyupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Account details has been updated successfully </span></div>');
			}
			redirect('admin/manage_company?id='.$url);
	  }
	  public function aboutsave(){
		  //print_r($this->input->post());		  
		  $about = base64_encode(serialize($this->input->post('aboutus'))); 
		  $companyid = $this->input->post('parentid');
		  $data=array(
					'company_id'	=>	$this->input->post('parentid'),
					'about'			=>	$about
					);
		  $companyget = $this->company_model->updateCompanydetails($data,array('company_id'=>$companyid));
		  $this->session->set_flashdata('companyupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>About us content has been updated successfully </span></div>');
		  $url = $this->input->post('url');
		  redirect('admin/manage_company?id='.$url);
	  }
	  public function socialsave(){
		  //print_r($this->input->post());exit;
		  $social=[];
		  $social['facebook']=$this->input->post('fb');
		  $social['twitter']=$this->input->post('tw');
		  $social['linkedin']=$this->input->post('ln');
		  $social['instagram']=$this->input->post('in');
		  $social['googleplus']=$this->input->post('gp');
		  $social['pinterest']=$this->input->post('pt');
		  $socialdb = base64_encode(serialize($social));
		  $companyid = $this->input->post('parentid');
		  $data=array(
					'company_id'	=>	$this->input->post('parentid'),
					'links'			=>	$socialdb
					);
		  $companyget = $this->company_model->updateCompanydetails($data,array('company_id'=>$companyid));
		  $this->session->set_flashdata('companyupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Social Links have been updated successfully.</span></div>');
		  $url = $this->input->post('url');
		  redirect('admin/manage_company?id='.$url);
	  }
}
?>
