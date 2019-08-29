<?php


class MY_model extends CI_Model
{
	protected $CI;
    // 错误信息
	protected $error;
	public function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
		$this->CI->load->database();
	}

    /**
     * 返回模型的错误信息
     * @access public
     * @return string|array
     */
    public function get_error()
    {
        return $this->error;
    }

}
