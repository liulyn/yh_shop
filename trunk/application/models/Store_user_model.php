<?php


class Store_user_model extends MY_model
//class Store_user_model extends CI_Model
{
    protected static $table_name = 'store_user';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 商城后台登录
     * @param $data
     * @return mixed
     */
    public function login($data)
    {
        if (!$res = $this->db->select('*')->from(self::$table_name)->where([
            'user_name' => $data['user_name'],
            'password' => shop_hash($data['password'])
        ])->get()->row_array()) {
            $this->error = '登录失败，用户名或密码错误';
            return false;
        }
        $this->CI->load->library('session');
        $this->CI->session->store = [
            'user' => [
                'store_user_id' => $res['store_user_id'],
                'user_name' => $res['user_name'],
            ],
            'is_login' => true,
        ];
        return true;
    }
}
