<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('dashboard_model');
		$this->load->helper(array('form', 'url'));
		$userdata= $this->session->userinfo;
		if(!$userdata){
			redirect('login');
		}
	}
	
	public function index(){
	$userdata= $this->session->userinfo;
	$companyid = $userdata->companyid;	
	$userid = $userdata->id;	
    $picture= $this->session->picture;
	if($userdata){
	$data = array(
		'view_file'     =>'index_content',
		'current_menu'  =>'dashboard',
		'site_title'    =>'File System Portal',
		'title'         =>'Dashboard',
		'content_title' =>'Dashboard',
		'userdata'		=> $userdata,
		'companyid'		=> $companyid,
		'userid'		=> $userid,
		'picture'		=> $picture,
		'files'         => array(
							"js" => array(
								"lib/jquery-toggles/toggles.js",
								"js/quirk.js"							   
								)
		)
	);
		$this->template->load_dashboard_template($data);
	}else{
		redirect('login');
	}
	}
	
}
?>
