<?php


//class Store_user_model extends MY_model
class Store_user_model extends CI_Model
{
	protected static $table_name = 'store_user';
	protected $CI;
	public function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
		$this->CI->load->database();
	}

	public function login_2($data){
		$this->db->select('*');
		$this->db->from(self::$table_name);
		$this->db->where('user_name',$data['user_name']);
		$this->db->where('password',yoshop_hash($data['password']));
		$query = $this->db->get();
		return $query->row_array();
	}
}
