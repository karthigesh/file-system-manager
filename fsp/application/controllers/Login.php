<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper(array('form', 'url'));
	}
	public function index(){
	    $data = array(
		    'view_file'=>'login',
		    'current_menu'=>'Login',
		    'site_title' =>'File System Portal',
		    'title'=>'Login',
		);
		$this->template->load_login_template($data);
	}
	public function submitlogin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$auth = $this->user_model->auth($username,$password);		
		if(($auth != FALSE)&&($auth != 'deactivated')){
			$this->session->set_userdata(array(
										'id' => $auth->id,
										'user_name'  => $auth->username,
										'email'      => $auth->email,
										'picture'	 => $auth->picture,
										'userinfo'=>$auth
								));
        redirect('dashboard');
		}else if(($auth != FALSE)&&($auth == 'deactivated')){
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User has been deactivated. Please contact superadmin</span></div>');
			redirect('login');
		}else{
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Username or password may be wrong.Please check username and password</span></div>');
			redirect('login');
		}
	}
public function submituserlogin(){

        $username = $this->input->post('username');
		$password = $this->input->post('password');
		$url = $this->input->post('companyname');
		$auth = $this->user_model->auth($username,$password);		
		if(($auth != FALSE)&&($auth != 'deactivated')){
			$this->session->set_userdata(array(
										'id' => $auth->id,
										'user_name'  => $auth->username,
										'email'      => $auth->email,
										'picture'	 => $auth->picture,
										'userinfo'=>$auth
								));
        redirect('dashboard');
		}else if(($auth != FALSE)&&($auth == 'deactivated')){
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> User has been deactivated. Please contact superadmin</span></div>');
			redirect('login');
		}else{
			$this->session->set_flashdata('login', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Username or password may be wrong.Please check username and password</span></div>');
            redirect('companyview/'.$url.'/login');
}
		
	}

}
