<?php


class MY_model extends CI_Model
{
	protected $CI;
	protected $db;
	public function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
		$this->db = $this->CI->load->database();
	}
}
