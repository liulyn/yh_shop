<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends CI_Controller
{

	public function index()
	{
		if ($this->input->is_ajax_request()) {
			echo 'ajax_index';
		}
		echo 'goods_index';
	}

	public function index2()
	{
		echo 'goods_index2';
	}
}
