<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->model('folder_model');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper(array('form', 'url'));
		$userdata= $this->session->userinfo;
		if(!$userdata){
			redirect('login');
		}
	}
	public function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('directory');
		$userdata= $this->session->userinfo;
		$picture= $this->session->picture;
		$record_num = $this->uri->segment_array();
		$foldername = end($record_num);
		if($foldername=='user'){
			  $userid = $userdata->id;
			  $usertype  = $this->user_model->getusertype($userdata->type);
			  $companyid = $userdata->companyid;
			  $companyini = $this->company_model->get_ini($companyid);
			  $companydetails = $this->company_model->getCompanydetails($companyid);
			  $folderget = $this->folder_model->getfolder(array('company'=>$companyid,'parent='=>""),'','','folder_name','ASC');
			  if($folderget !=""){
				$folders = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
			  }else{
				$folders = "";
			  }  
			  $filesget = $this->folder_model->getfiles(array('company'=>$companyid,'directory'=>'folders'),'','','name','ASC');
			  if($filesget !=""){
				$files = ($filesget->num_rows() > 0) ? $filesget->result() : FALSE;
			  }else{
				$files = "";
			  }
			  $permissionget = $this->company_model->getuserrequeststatus(array('uid'=>$userid));
			  if($permissionget !=""){
				$permission = ($permissionget->num_rows() > 0) ? $permissionget->result() : FALSE;
			  }else{
				$permission = "";
			  }
			  $dir = FCPATH. "folders/";
			  $filepath = BASE_URL."folders/";
			  $data = array(
				'view_file'     	=>'userfolders',
				'current_menu'  	=>'userfolders',
				'site_title'    	=>'File System Portal',
				'title'         	=>'Company Folders',
				'content_title' 	=>'Company Folders',
				'ini'				=> $companyini,
				'permission'		=> $permission,
				'userdata'			=> $userdata,
				'usertype'			=> $usertype,
				'company'			=> $companydetails,
				'filepath'			=> $filepath,
				'mapfolders'		=> $folders,
				'mapfiles'			=> $files,
				'picture'			=> $picture,
				'files'         	=> array(
									"css"=> array(
										"css/dropzone.css",
										"lib/jquery-toggles/toggles-full.css",
										"lib/select2/select2.css",
									),
									"js" => array(
										"js/dropzone.js",
										"lib/jquery-toggles/toggles.js",
										"lib/select2/select2.js",
										"js/quirk.js",
										"js/jquery.validate.min.js"
										)
									)
				);
				$this->template->load_folder_template($data);
			}else{
				$userdata= $this->session->userinfo;
				$userid = $userdata->id;
				$companyid = $userdata->companyid;
				$this->load->helper('directory');
				$companyini = $this->company_model->get_ini($companyid);
				$record_num = $this->uri->segment_array();
				$foldername = end($record_num);
				$folderset = $this->folder_model->folderid($foldername);
				$parentfolderid = $folderset->id;
				$folderget = $this->folder_model->getfolder(array('owner'=>$userid,'company'=>$companyid,'parent='=>$parentfolderid),'','','folder_name','ASC');
				if($folderget !=""){
					$folders = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
				}else{
					$folders = "";
				}  
				$filesget = $this->folder_model->getfiles(array('owner'=>$userid,'company'=>$companyid,'directory'=>$foldername),'','','name','ASC');
				if($filesget !=""){
					$files = ($filesget->num_rows() > 0) ? $filesget->result() : FALSE;
				}else{
					$files = "";
				}
				$permissionget = $this->company_model->getuserrequeststatus(array('uid'=>$userid));
				  if($permissionget !=""){
					$permission = ($permissionget->num_rows() > 0) ? $permissionget->result() : FALSE;
				  }else{
					$permission = "";
				  }
				  $usertype  = $this->user_model->getusertype($userdata->type);
				  $compinfo = $this->user_model->getUser(array("id" => $companyid));
				  $compdetails = ($compinfo->num_rows() > 0) ? $compinfo->result() : FALSE;
				  $companynamedetails = $this->company_model->getCompanydetails($companyid);
				  if($companynamedetails != false){
					 $companynamedetails =$companynamedetails;
				  }else{
					$companynamedetails = "";
				  }
				  $data = array(
					'view_file'     =>'userfiles',
					'current_menu'  =>'folders',
					'site_title'    =>'File System Portal',
					'title'         =>'Company Folders',
					'content_title' =>'Company Folders',
					'ini'			=> $companyini,
					'userdata'		=> $userdata,
					'usertype'		=> $usertype,
					'companyid'		=> $companyid,
					'compdetails'   => $compdetails,
					'permission'	=> $permission,
					'foldername'	=> $foldername,
					'company'		=> $companynamedetails,
					'mapfolders'	=> $folders,
					'mapfiles'		=> $files,
					'picture'		=> $picture,
					'files'         => array(
										"css"=> array(
											"lib/jquery-toggles/toggles-full.css",
											"css/dropzone.css",
											"lib/select2/select2.css",
										),
										"js" => array(
											"lib/jquery-toggles/toggles.js",
											"js/dropzone.js",
											"lib/select2/select2.js",
											"js/quirk.js",
											"js/jquery.validate.min.js"
											)
										)
					);
					$this->template->load_folder_template($data);
		  }
	}
}
