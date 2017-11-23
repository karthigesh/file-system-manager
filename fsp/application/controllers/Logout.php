<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper(array('form', 'url'));
	}
	public function index()
	{
		// Update logout time
		$this->user_model->updateUser(
			array(
				'modified'=>date('Y-m-d H:i:s')
			),
			array(
				'id'=>$this->session->id
			)
		);
		$this->destroy_user();
	}
	public function destroy_user(){
       $this->session->sess_destroy();
		redirect('login');
	}
}
