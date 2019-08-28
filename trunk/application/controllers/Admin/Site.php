<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 登录验证
 * Class Site
 */
class Site extends CI_Controller
{

	public function index()
	{
		$this->login();

	}

	/**
	 * 商城后台登录
	 */
	public function login()
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('store_user_model');
//			$result = $this->store_user_model->login_2($this->input->post('User'));
			if($this->store_user_model->login_2($this->input->post('User'))){
				exit('登录成功');
			}
			exit('登录失败');
		}
		$this->load->view('admin/login');
	}
}
