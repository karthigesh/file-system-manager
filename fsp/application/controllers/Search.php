<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('search_model');
		$this->load->model('folder_model');
		$this->load->model('company_model');
		$this->load->helper(array('form', 'url'));
		$userdata= $this->session->userinfo;
		if(!$userdata){
			redirect('login');
		}
	}
	
	public function index()
    {
			$userdata= $this->session->userinfo;
			 $companyid = $userdata->companyid; 
			$keyword            =   $this->input->post('keyword');
			$data    =   $this->search_model->search($keyword,$companyid);
			//echo '<pre>';print_r($data);exit;
			$files= $data['file'];
			$folders= $data['folder'];
			$picture= $this->session->picture;
			$usertype  = $this->user_model->getusertype($userdata->type);
			$compinfo = $this->user_model->getUser(array("id" => $companyid));
			$compdetails = ($compinfo->num_rows() > 0) ? $compinfo->result() : FALSE;
			$companynamedetails = $this->company_model->getCompanydetails($companyid);
			if($companynamedetails != false){
			 $companynamedetails =$companynamedetails;
			}else{
			$companynamedetails = "";
			}
			$userini = $this->company_model->get_ini($companyid);
			if($compdetails){
			$data = array(
				'view_file'     	=>'search',
				'current_menu'  	=>'folders',
				'site_title'    	=>'File System Portal',
				'title'         	=>'Company Folders',
				'content_title' 	=>'Company Folders',
				'userdata'			=>$userdata,
				'usertype'			=>$usertype,
				'companyid'			=> $companyid,
				'compdetails'   	=> $compdetails,
				'company'			=> $companynamedetails,
				'mapfolders'		=> $folders,
				'mapfiles'			=> $files,
				'picture'			=> $picture,
				'ini'				=> $userini,
				'files'         	=> array(
									"css"=> array(
										"css/dropzone.css",
										"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
										"lib/jquery-toggles/toggles-full.css",
									),
									"js" => array(
										"js/dropzone.js",
										"lib/datatables/jquery.dataTables.js",
										"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
										"lib/jquery-toggles/toggles.js",
										"js/quirk.js",
										"js/jquery.validate.min.js"
										)
									)
				);
				$this->template->load_folder_template($data);
    }
	
}

public function user_search()
    {
			$userdata= $this->session->userinfo;
			$companyid = $userdata->companyid;
			$keyword    =   $this->input->post('keyword');
			$data    =   $this->search_model->user_search($keyword,$companyid);
			//echo '<pre>';print_r($data);exit;
			$files= $data['file'];
			$folders= $data['folder'];
	          $picture= $this->session->picture;
			  $usertype  = $this->user_model->getusertype($userdata->type);
			  $compinfo = $this->user_model->getUser(array("id" => $companyid));
			  $compdetails = ($compinfo->num_rows() > 0) ? $compinfo->result() : FALSE;
			  $companynamedetails = $this->company_model->getCompanydetails($companyid);
			  if($companynamedetails != false){
				 $companynamedetails =$companynamedetails;
			  }else{
				$companynamedetails = "";
			  }
			  $userini = $this->company_model->get_ini($companyid);
			  if($compdetails){
			  $data = array(
				'view_file'     	=>'user_search',
				'current_menu'  	=>'folders',
				'site_title'    	=>'File System Portal',
				'title'         	=>'Company Folders',
				'content_title' 	=>'Company Folders',
				'userdata'			=>$userdata,
				'usertype'			=>$usertype,
				'companyid'			=> $companyid,
				'compdetails'   	=> $compdetails,
				'company'			=> $companynamedetails,
				'mapfolders'		=> $folders,
				'mapfiles'			=> $files,
				'picture'			=> $picture,
				'ini'				=> $userini,
				'files'         	=> array(
									"css"=> array(
										"css/dropzone.css",
										"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
										"lib/jquery-toggles/toggles-full.css",
									),
									"js" => array(
										"js/dropzone.js",
										"lib/datatables/jquery.dataTables.js",
										"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
										"lib/jquery-toggles/toggles.js",
										"js/quirk.js",
										"js/jquery.validate.min.js"
										)
									)
				);
				$this->template->load_folder_template($data);
    }
	
}
}
